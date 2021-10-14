<?php
// ========================================================
// Configuration Settings
// ========================================================


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

$_required_config_vars = array("app_name","wol_broadcast","webcam_url","arduino_url","platforms");
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
$_h = new HardwareActivity($_config->platforms);
define("NAME", $_config->app_name);


