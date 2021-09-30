<?php
	
	require_once 'resources/config.php';
	require_once 'template/header.php';


	switch ($s) 
	{
		case 'config': 
			require_once 'resources/view/configuration.php';
			break;

		case 'updates':
			require_once 'resources/view/updates.php';
			break;
	
		case 'webcam':
			require_once 'resources/view/webcam.php';
			break;

		default:
			require_once 'resources/view/dashboard.php';
			break;
	}


	require_once 'template/footer.php';

?>

