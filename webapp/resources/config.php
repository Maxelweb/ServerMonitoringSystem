<?php

// Configuration File

ini_set('display_errors', 1);
ini_set("allow_url_fopen", 1);
error_reporting(E_ALL);


// ========================================================
// Configuration Settings - EDIT FROM HERE
// ========================================================

define("NAME", "myserver"); // Server location or name

define("API_ARDUINO", "12345"); // API secret code to interact with arduino

define("SCRIPT_PATH", "/home/myusername/script.py"); // Python script location 




// DO NOT CHANGE UNDER THIS LINE
// ========================================================

define("REPO", "https://github.com/Maxelweb/ServerMonitoringSystem");
define("VERSION", "0.1");

$s = isset($_GET['s']) ? $_GET['s'] : "";
$a = isset($_GET['a']) ? $_GET['a'] : 0;


// Libs


use ServerMonitor\Core as SMC;
use ServerMonitor\Extra as SME;

require_once 'core.php';
require_once 'ServerMonitor.core.php';
require_once 'ServerMonitor.extra.php';




