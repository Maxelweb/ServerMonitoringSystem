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
elseif($s == "wakeup")
{
	echo wakeUp($id);
}