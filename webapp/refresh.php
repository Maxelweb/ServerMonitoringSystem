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


	echo rand(-3,38);
}