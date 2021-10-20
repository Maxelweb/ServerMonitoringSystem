<?php 

class HardwareActivity
{
	private $platforms;
	private $cplat = array(); // status of the platforms

	function __construct($platformsArray)
	{
		if(!empty($platformsArray)) 
		{
			$this->platforms = (array) $platformsArray;
			// $this->checkAllActivities();
		}
	}

	private function getKeyFromName($name)
	{
		return array_search($name, array_column($this->platforms, 'name'));
	}

	function checkActivity($name)
	{
		$key = $this->getKeyFromName($name);
		if($key !== false)
		{
			exec("ping -c 1 ".$this->platforms[$key]->ip_addr, $output, $result);
			var_dump($result);
			$this->cplat[$name] = $result == 0;
			return $result == 0;
		}
		return false;
	}

	function areAllActive()
	{
		$i = 0;
		foreach($this->cplat as $n => $v)
			if($v) $i++; 
		return $i;
	}

	function checkAllActivities()
	{
		foreach($this->platforms as $item){
			$this->checkActivity($item->name);
		}
	}

	function printStaticWidget()
	{
		global $_config; 

		if(!empty($this->platforms))
		{
			echo '<div class="widget widget-default widget-left widget-wide">
					<div class="title">
						<i class="fas fa-circle fa-xs icon-blink" style="color: orange"></i>
						<i class="fas fa-sm fa-server"></i>
						<small>Hardware Activity</small>
					</div>	
					<div class="content">
						<div class="responsive">
							<table id="hardwareTable" class="sortable">
								<tr>
									<th onclick="sortTable(0)">Device &#8597;</th>
									<th onclick="sortTable(1)">IP Address &#8597;</th>
									<th onclick="sortTable(2)">Status &#8597;</th>
									<th onclick="sortTable(3)">Action &#8597;</th>
								</tr>';

					if(!empty($this->platforms))
					sort($this->platforms);
					foreach ($this->platforms as $item) 
						echo "<tr class='itemDevice' id='$item->name'>
								<td>".$item->name."</td>
								<td><code>".$item->ip_addr."</code></td>
								<td class='itemDeviceStatus'><i class='fas fa-circle-notch fa-spin'></i></td>
								<td class='itemDeviceAction'><i class='fas fa-circle-notch fa-spin'></i>
								</td>
								</tr>";

			echo '			</table>
					  	</div>
					</div>
				  </div>';
		}
	}

	function refreshDeviceRow($name) {
		
		$key = getKeyFromPlatformName($name);
		if($key !== false) {

			$item = $this->platforms[$key];
			$activity = $this->checkActivity($name);

			echo "	<td>".$item->name."</td>
					<td><code>".$item->ip_addr."</code></td>
					<td class='itemDeviceStatus'>".($activity ? success("online", 1) : error("offline", 1))."</td>
					<td class='itemDeviceAction'>".(!$activity && !empty($item->mac_addr) ? "<small><a href='javascript:void(0)' onclick=\"wakeUp('".$item->name."')\">Wake up</a></small>" : "-") . "
					</td>";
		}

	}
}


