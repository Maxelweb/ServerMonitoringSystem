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
</head>
<body>

<header>
	<h1>Server Monitoring System</h1>
	<h2><?=NAME;?></h2>
</header>

<nav>
	<a href="?"><i class="fas fa-home"></i> Dashboard</a>
	<a href="?"><i class="fas fa-server"></i> Wake-On-Lan</a>
	<a href="?s=webcam"><i class="fas fa-camera"></i> Webcam</a>
	<a href="?"><i class="fas fa-edit"></i> Configuration</a>
	<a href="?s=updates"><i class="fas fa-coffee"></i> Updates</a>
</nav>

<article>