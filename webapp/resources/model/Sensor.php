<?php

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
		if($this->value < 10 || $this->value > 30)
			$this->status = "danger";
		elseif($this->value < 15 || $this->value > 25)
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
		elseif($this->value >= 60 || $this->value <= 15)
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
			$this->status = "default-danger";
			$this->content = 'The light in the room is <strong>ON</strong>';
			$this->iconType = "far";
		}
		else
		{
			$this->status = "default-success";
			$this->content = 'The light in the room is <strong>OFF</strong>';
		}

	}

}


class IntrusionDetection extends Sensor
{
	function __construct($jsonValue)
	{
		$this->name = "Intrusion Detection";
		$this->value = $jsonValue;
		$this->icon = "smile-beam";
		$this->iconType = "far";
		$this->build();
	}

	protected function build()
	{
		if($this->value == 1)
		{
			$this->status = "danger";
			$this->content = 'Someone might be in the Room';
			$this->icon = "meh-rolling-eyes";
		}
		else
		{
			$this->status = "default-success";
			$this->content = 'No one in the Room';
		}

	}

}

