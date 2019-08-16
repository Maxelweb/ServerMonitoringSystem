<?php

require_once 'resources/config.php';

if($s == "dashboard-sensors")
{
	showSensorsWidgets();
}
elseif($s == "dashboard-hardware")
{
	showHardwareWidget();
}
elseif($s == "realtime")
{

	// Arduino connection
	// ...

	$temp = rand(10, 40);
	$hum = rand(20, 90);

	$json = json_encode(array("temperature" => $temp, "humidity" => $hum));
	echo $json;


}