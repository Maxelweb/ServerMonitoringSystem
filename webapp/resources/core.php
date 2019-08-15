<?php 


function showSensorsWidgets()
{
	// Arduino connection
	// with handshake - TO DO
	// $ard = new ArduinoConnector();


	// tmp json
	$jsonTmp = file_get_contents("data.json");
	
	$sensors = unserializeData($jsonTmp);

	foreach($sensors as $sensor)
	{
		$sensor->printWidget();
	}

}

function showHardwareWidget()
{
	global $_platforms;

	$h = new HardwareActivity($_platforms);
	$h->printWidget();

}

function showLogsList()
{
	// Arduino connection
	// with handshake - TO DO
	// $ard = new ArduinoConnector();

	$jsonTmp = file_get_contents(filename);
}

function unserializeData($json)
{
	$items = json_decode($json);
	$sensors = array();

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
			
			case 'door' : 
				array_push($sensors, new Door($value));
				break;

			case 'light' : 
				array_push($sensors, new Light($value));
				break;

			default:
				break;
		}
	}

	return $sensors;
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
