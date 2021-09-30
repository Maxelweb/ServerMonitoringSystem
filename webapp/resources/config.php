<?php
// ========================================================
// Configuration Settings
// ========================================================

// define("NAME", "Home"); // Server location or name
// define("SCRIPT_PATH", "/home/maxel/sms/client.py"); // Python script location 

// $_platforms = array(				// Check activity of these platforms
// 	"Raspberry" => "192.168.1.250",
// 	"Internet" => "192.168.1.254"
// );

// $_wol_mac = array(					// MAC address
// 	"Raspberry" => "AA:BB:CC:DD"
// );

// 									// wol lan broadcast
// $_wol_broadcast = "255.255.255.0";

// $_webcam_url = ""; // Webcam url

define("SCRIPT_PATH", dirname(__FILE__)."/utils/client.py"); // Python script location 
define("CONFIG_FILE", dirname(__FILE__)."/database/config.json");
define("REPO", "https://github.com/Maxelweb/ServerMonitoringSystem");
define("VERSION", "1.0.0");
define("DEBUG", true);

if(DEBUG)
{
	ini_set('display_errors', 1);
	ini_set("allow_url_fopen", 1);
	error_reporting(E_ALL);
}

// Initialize global variables

$_config = (object) array();
$s = isset($_GET['s']) ? $_GET['s'] : "";
$a = isset($_GET['a']) ? $_GET['a'] : 0;
$id = isset($_GET['id']) ? $_GET['id'] : 0;


// Libs

require_once 'utils/functions.php';
require_once 'model/HardwareActivity.php';
require_once 'model/Sensor.php';
require_once 'model/Updates.php';

// Initialize configuration

initializeConfiguration();

define("NAME", $_config->app_name);


