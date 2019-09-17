<?php 

function arduino_requestData()
{
    $shellCommand = escapeshellcmd('python3 ' . SCRIPT_PATH . " get_data");
    $shellOutput = trim(shell_exec($shellCommand));

 	if(strlen($shellOutput) > 20 || $shellOutput == "NULL" || $shellOutput == "ERROR")
 		return array();
 	else
 	{
 		$it = explode(",", $shellOutput);
 		$kit = array("temperature", "humidity", "door", "light");
 		$data = array_combine($kit, $it);
 		return $data;
 	}
}


function showSensorsWidgets()
{
	$sensors = unserializeData(arduino_requestData());

	if(!empty($sensors))
		foreach($sensors as $sensor)
		{
			$sensor->printWidget();
		}
	else
	{
		echo '<span class="box bad hide" id="ErrorSensors">
				<i class="fas fa-exclamation-circle"></i> Error: no data fetched. Reload the page or wait for automatic refresh.
			</span>';
	}

}

function showHardwareWidget()
{
	global $_platforms;

	$h = new HardwareActivity($_platforms);
	$h->printWidget();

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
