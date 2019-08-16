<!DOCTYPE html>
<html>
<head>
	<title>Server Monitoring System (SMS)</title>
	<meta content='width=device-width, initial-scale=1' name='viewport'>
	<meta name="description" content="Server Monitoring System - SMS">
  	<meta name="keywords" content="SMS,Monitoring,System,Server">
  	<meta name="author" content="Mariano Sciacco">
  	<link rel="stylesheet" href="style/main.css">
  	<link rel="stylesheet" href="style/widgets.css">
  	<link rel="stylesheet" href="style/fontawesome/all.min.css">
  	<script src="style/js/jquery-3.4.1.min.js"></script>
  	<script src="style/js/Chart.bundle.min.js"></script>
</head>
<body>

<header>
	<h1>Server Monitoring System</h1>
	<h2><?=NAME;?></h2>
</header>

<nav>
	<a href="?">&#x1F3E0; Dashboard</a>
	<a href="?s=real-time">&#x1F4B9; Real-time Charts</a>
	<!--<span>&#x1F5C3; <a href="?s=logs">Logs</a></span>-->
	<a href="?s=updates">&#x2615; Updates</a>
</nav>

<article>