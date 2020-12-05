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


function showWebcam($stream=true) {
	global $_webcam_url;
	$url = $stream ? $_webcam_url.'?action=stream' : $_webcam_url;
	echo "<img src='$url'>";
}


# Taken from https://github.com/justicenode/php-wol/blob/master/html/wake.php

function wakeUp($id)
{
	global $_wol_mac;
	global $_wol_broadcast;

	if(isset($_wol_mac[$id]))
	{
		$broadcast = $_wol_broadcast;
		$mac_array = explode(':', $_wol_mac[$id]);
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
	}
	else
		return false;
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
