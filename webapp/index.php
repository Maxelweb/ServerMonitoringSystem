<?php
	
	require_once 'resources/config.php';
	require_once 'template/header.php';


	switch ($s) 
	{
		
		/*case 'real-time':
			require_once 'resources/pages/real-time.php';
			break;
		
		case 'logs':
			require_once 'resources/pages/logs.php';
			break;
		*/
			
		case 'updates':
			require_once 'resources/pages/updates.php';
			break;
	
		case 'webcam':
			require_once 'resources/pages/webcam.php';
			break;

		default:
			require_once 'resources/pages/dashboard.php';
			break;
	}


	require_once 'template/footer.php';

?>

