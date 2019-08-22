<?php
// ========================================================
// Configuration Settings - EDIT FROM HERE
// ========================================================

define("NAME", "myserver"); // Server location or name
define("SCRIPT_PATH", "/home/maxel/sms/client.py"); // Python script location 

$_platforms = array(				// Check activity of these platforms
	"Raspberry" => "192.168.1.250",
	"Internet" => "192.168.1.1"
);


// DO NOT CHANGE UNDER THIS LINE
// ========================================================

define("REPO", "https://github.com/Maxelweb/ServerMonitoringSystem");
define("VERSION", "0.1");
define("DEBUG", true);

if(DEBUG)
{
	ini_set('display_errors', 1);
	ini_set("allow_url_fopen", 1);
	error_reporting(E_ALL);
}

$s = isset($_GET['s']) ? $_GET['s'] : "";
$a = isset($_GET['a']) ? $_GET['a'] : 0;
$id = isset($_GET['id']) ? $_GET['id'] : 0;


// Libs

require_once 'core.php';
require_once 'ServerMonitor.core.php';
require_once 'ServerMonitor.extra.php';




