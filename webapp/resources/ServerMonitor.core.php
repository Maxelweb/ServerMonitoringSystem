<?php 
namespace ServerMonitor\Core;


class ArduinoConnector
{
	private $error;
	private $payload;
	private $lastPayload;
	
	function __construct()
	{
		$this->arduinoHandshake();
	}

	private function updatePayload($pay)
	{
		if($this->payload != $pay)
		{
			$this->payload = $pay;
			$this->lastPayload = time();
			$this->error = 0;
		}
	}

	private function arduinoHandshake()
	{
     
	    $shellCommand = escapeshellcmd(SCRIPT_PATH . ' ' . API_ARDUINO);
	    $shellOutput = shell_exec($shellCommand);
     
     	if($shellOutput == 0)
     		$this->error = 1;
     	else
     		$this->updatePayload($shellOutput);
	}

	public function error()
	{
		return $this->error;
	}

	public function getPayload()
	{
		return $this->payload;
	}

	public function getLastPayloadTime()
	{
		return date('Y-m-g H:i:s', $this->lastPayload);
	}
	
}



abstract class Sensor
{
	protected $value;
	protected $name;
	protected $icon;
	protected $status;

	public function getName()
	{
		return $this->name;
	}

	public function getValue()
	{
		return $this->value;
	}

	abstract protected function makeStatus();

	abstract public function printWidget();
	
}


class Temperature extends Sensor
{
	function __construct($jsonValue)
	{
		$this->name = "Room Temperature";
		$this->icon = "thermometer-half";
		$this->value = $jsonValue;
		$this->makeStatus();
	}

	protected function makeStatus()
	{
		if($this->value < 2 || $this->value > 40)
			$this->status = "danger";
		elseif($this->value < 15 || $this->value > 30)
			$this->status = "warning";
		else
			$this->status = "success";

	}

	public function printWidget()
	{
		echo '<div class="widget widget-'.$this->status.'">
				<div class="title"> <i class="fas fa-lg fa-'.$this->icon.'"></i> '.$this->name.'</div>	
				<div class="content">'.$this->value.'&deg; C</div>
			  </div>';
	}

}
