<?php 

class HardwareActivity
{
	private $platforms;
	private $cplat = array();

	function __construct($platformsArray)
	{
		if(!empty($platformsArray)) 
		{
			$this->platforms = $platformsArray;
			$this->checkActivity();
		}
	}

	function checkActivity()
	{
		foreach($this->platforms as $name => $ip)
		{
			exec("ping -c 1 ".$ip, $output, $result);
			$this->cplat[$name] = $result==0;
		}
	}

	function active()
	{
		$i = 0;
		foreach($this->cplat as $n => $v)
			if($v) $i++; 
		return $i;
	}

	function printWidget()
	{
		if(!empty($this->platforms))
		{
			if($this->active() == count($this->cplat))
				$col = "green";
			elseif($this->active() == 0)
				$col = "red";
			else
				$col = "orange";


			echo '<div class="widget widget-default widget-left">
					<div class="title">
						<i class="fas fa-circle fa-xs icon-blink" style="color: '.$col.'"></i>
						<i class="fas fa-sm fa-server"></i>
						<small>Hardware Activity</small>
					</div>	
					<div class="content">
						<div class="responsive">
							<table>';

			if(!empty($this->cplat))
				foreach ($this->cplat as $key => $value) 
					echo "<tr>
							<th>$key</th>
							<td>".($value ? success("online",1) : error("offline",1))."</td>
						  </tr>";

			echo '			</table>
					  	</div>
					</div>
				  </div>';
		}
	}
}


abstract class Sensor
{
	protected $value;
	protected $content;
	protected $name;
	protected $icon;
	protected $iconType = "fas";
	protected $status;

	abstract protected function build();

	public function getName()
	{
		return $this->name;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function getIcon()
	{
		return $this->icon;
	}

	public function getIconType()
	{
		return $this->iconType;
	}

	public function printWidget()
	{
		echo '<div class="widget widget-'.$this->status.'">
				<div class="title"> <i class="'.$this->iconType.' fa-lg fa-'.$this->icon.'"></i> '.$this->name.'</div>	
				<div class="content">'.$this->content.'</div>
			  </div>';
	}
	
}


class Temperature extends Sensor
{
	function __construct($jsonValue)
	{
		$this->name = "Room Temperature";
		$this->icon = "thermometer-half";
		$this->value = $jsonValue;
		$this->build();
	}

	protected function build()
	{
		if($this->value < 2 || $this->value > 40)
			$this->status = "danger";
		elseif($this->value < 15 || $this->value > 30)
			$this->status = "warning";
		else
			$this->status = "success";

		$this->content = $this->value . '&deg; C';
	}
}

class Humidity extends Sensor
{
	function __construct($jsonValue)
	{
		$this->name = "Room Humidity";
		$this->icon = "tint";
		$this->value = $jsonValue;
		$this->build();
	}

	protected function build()
	{
		if($this->value >= 80)
			$this->status = "danger";
		elseif($this->value >= 60)
			$this->status = "warning";
		else
			$this->status = "success";

		$this->content = $this->value . '&#37; <small>(0 - 100)</small>';
	}

}

class Door extends Sensor
{
	function __construct($jsonValue)
	{
		$this->name = "Door";
		$this->value = $jsonValue;
		$this->build();
	}

	protected function build()
	{
		if($this->value == 1)
		{
			$this->status = "default-danger";
			$this->content = 'The door is <strong>OPEN</strong>';
			$this->icon = "door-open";
		}
		else
		{
			$this->status = "default-success";
			$this->content = 'The door is <strong>CLOSED</strong>';
			$this->icon = "door-closed";
		}

	}

}

class Light extends Sensor
{
	function __construct($jsonValue)
	{
		$this->name = "Light";
		$this->value = $jsonValue;
		$this->icon = "lightbulb";
		$this->build();
	}

	protected function build()
	{
		if($this->value == 1)
		{
			$this->status = "default-warning";
			$this->content = 'The light in the room is <strong>ACTIVE</strong>';
			$this->iconType = "far";
		}
		else
		{
			$this->status = "default-success";
			$this->content = 'The light in the room is <strong>INACTIVE</strong>';
		}

	}

}


