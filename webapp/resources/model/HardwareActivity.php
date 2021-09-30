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
			$this->checkAllActivities();
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
			$this->cplat[$name] = $result == 0;
		}
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

	function printWidget()
	{
		global $_config; 

		if(!empty($this->platforms))
		{
			echo '<div class="widget widget-default widget-left">
					<div class="title">
						<i class="fas fa-circle fa-xs icon-blink" style="color: orange"></i>
						<i class="fas fa-sm fa-server"></i>
						<small>Hardware Activity</small>
					</div>	
					<div class="content">
						<div class="responsive">
							<table>';

			if(!empty($this->cplat))
				foreach ($this->cplat as $name => $value) 
					echo "<tr>
							<th>$name</th>
							<td>".($value ? success("online", 1) : error("offline",1))." 
								".(!$value && isset($this->platforms[$this->getKeyFromName($name)]->mac_addr) ? "<small>(<a href='javascript:void(0)' onclick=\"wakeUp('".$name."')\">Wake up</a>)</small>" : '')."</td>
						  </tr>";

			echo '			</table>
					  	</div>
					</div>
				  </div>';
		}
	}
}


