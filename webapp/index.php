<?php
	
	require_once 'resources/config.php';
	require_once 'template/header.php';

	switch ($s) 
	{
		case 'updates':
			break;
		
		default:
			require_once 'resources/pages/dashboard.php';
			break;
	}


	require_once 'template/footer.php';

?>

