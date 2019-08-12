<?php

class Updates
{
	private $version;
	private $payload;
	
	function __construct()
	{ 
		$this->version = VERSION;
		$this->payload = $this->checkNewVersion();
	}
	private function checkNewVersion()
	{
		$json = file_get_contents('http://api.debug.ovh/sms.json');
		if(!$json)
			return array();
		return json_decode($json);
	}
	function currentVersion()
	{
		return $this->version;
	}
	function latestVersion()
	{
	 	if(!empty($this->payload))
	 		return $this->payload->version;
	 	return "N/A";
	}
	function info()
	{
		return $this->payload;
	}
}


function success($msg, $simple=0)
{
	$cl = !$simple ? "good box" : "good";
	return '<span class="'.$cl.'">'.$msg.'</span>';
}
function error($msg, $simple=0)
{
	$cl = !$simple ? "bad box" : "bad";
	return '<span class="'.$cl.'">'.$msg.'</span>';
}

