<?php 

// Configuration
// ====================================

function initializeConfiguration() {
	global $_config;
	
	$configFile = fopen(CONFIG_FILE, "r") or die("Error retrieving the configuration, the path is probably empty!");
	$rawFile = fread($configFile, filesize(CONFIG_FILE));
	$_config = json_decode($rawFile, false);
	if($_config === NULL) 
		die("Error retrieving the configuration, the config.json file is corrupted");
}



function editConfiguration($new_config) {
	global $_config, $_required_config_vars;
	$config_raw = strip_tags($new_config);
	$config_decode = json_decode($config_raw);
	if($config_decode === NULL)
		return false;
	else {

		// TODO: add JSON-schema validator instaed of this

		if(count($_required_config_vars) != count(array_keys( (array) $config_decode)))
			return false;

		foreach($_required_config_vars as $key => $val)
			if(!array_key_exists($val, (array) $config_decode))
				return false;
		
		$configFile = fopen(CONFIG_FILE, "w+") or die("Error editing configuration!");
		fwrite($configFile, json_encode($config_decode));
		$_config = $config_decode;
	}
	return true;
}


// Arduino Interface
// ====================================

function arduinoRequestData($sensor_name = "")
{
    global $_config;
	if(empty($sensor_name))
		$data_raw = @file_get_contents($_config->arduino_url . "/sensors");
	else 
		$data_raw = @file_get_contents($_config->arduino_url . "/sensors". "/". $sensor_name);

 	if($data_raw === false || empty($data_raw) || strlen($data_raw) < 3)
 		return array();
 	else
 	{
		$data = json_decode($data_raw);
 		return $data;
 	}
}


// Webcam Interface
// ====================================

function showWebcam($stream=true) {
	global $_webcam_url;
	$url = $stream ? $_webcam_url.'?action=stream' : $_webcam_url;
	echo "<img src='$url'>";
}


// Wake-On-Lan
// ====================================
# Taken from https://github.com/justicenode/php-wol/blob/master/html/wake.php

function getItemFromPlatformName($name){
	global $_config;
	$platforms = (array) $_config->platforms;
	$key = array_search($name, array_column($platforms, "name"));
	return (object) $platforms[$key];
}

function getKeyFromPlatformName($name){
	global $_config;
	$platforms = (array) $_config->platforms;
	return array_search($name, array_column($platforms, "name"));
}


function wakeUp($platform_name)
{
	global $_config;

	$broadcast = $_config->wol_broadcast;
	$mac_array = explode(':', getItemFromPlatformName($platform_name)->mac_addr);
	$hw_addr = '';

	foreach($mac_array AS $octet) 
		$hw_addr .= chr(hexdec($octet));

	$packet = '';
	for ($i = 1; $i <= 6; $i++)
		$packet .= chr(255);

	for ($i = 1; $i <= 16; $i++) 
		$packet .= $hw_addr;

	$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
	if($sock) 
	{
		$options = socket_set_option($sock, 1, 6, true);
		if ($options >=0) 
		{    
			$e = socket_sendto($sock, $packet, strlen($packet), 0, $broadcast, 7);
			socket_close($sock);
			return true;
		}    
	}
	return false;
}


// View utils
// ====================================

function showSensorWidget($sensor) {
	$sensors = unserializeData(arduinoRequestData($sensor));

	if(!empty($sensors))
		foreach($sensors as $sensor) {
			$sensor->printWidget();
		}
	else
		echo '<span class="box bad" id="ErrorSensors">
				<i class="fas fa-exclamation-circle"></i> Error: no data fetched. Reload the page or wait for automatic refresh.
			</span>';
	
}

function showSensorsWidgets()
{
	$sensors = unserializeData(arduinoRequestData());

	if(count($sensors) != 0){
		foreach($sensors as $sensor) 
			$sensor->printWidget();
	} else { 
		echo '<span class="box bad" id="ErrorSensors">
				<i class="fas fa-exclamation-circle"></i> Error: no data fetched. Reload the page or wait for automatic refresh.
			 </span>';
	}
}

function unserializeData($items)
{
	$sensors = array();

	if(!empty($items))
		foreach ($items as $key => $value) 
		{
			switch ($key) 
			{
				case 'temperature' :
					array_push($sensors, new Temperature($value));	
					break;

				case 'humidity' : 
					array_push($sensors, new Humidity($value));
					break;
				
				case 'door_open' : 
					array_push($sensors, new Door($value));
					break;

				case 'lights_up' : 
					array_push($sensors, new Light($value));
					break;
				
				case 'intrusion_detection' : 
					array_push($sensors, new IntrusionDetection($value));
					break;

				default:
					break;
			}
		}

	return $sensors;
}


function showHardwareWidget()
{
	global $_h;
	$_h->printStaticWidget();
}

// Extra
// ====================================

function isValidJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

function success($msg, $simple=0) {
	$cl = !$simple ? "good box" : "good";
	return '<span class="'.$cl.'">'.$msg.'</span>';
}

function error($msg, $simple=0) {
	$cl = !$simple ? "bad box" : "bad";
	return '<span class="'.$cl.'">'.$msg.'</span>';
}
