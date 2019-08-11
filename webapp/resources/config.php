<?php


ini_set('display_errors', 1);
ini_set("allow_url_fopen", 1);
error_reporting(E_ALL);

define("REPO", "https://github.com/Maxelweb/ServerMonitoringSystem");
define("VERSION", "0.1");

$s = isset($_GET['s']) ? $_GET['s'] : "";
$a = isset($_GET['a']) ? $_GET['a'] : 0;



