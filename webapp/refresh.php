<?php

require_once 'resources/config.php';

if($s == "dashboard-sensors")
{
	showSensorsWidgets();
}
elseif($s == "hardware")
{
	$_h->refreshDeviceRow($id);
}
elseif($s == "wakeup")
{
	echo wakeUp($id);
}
elseif($s == "webcam")
{
	showWebcam();
}