<?php

use ServerMonitor\Core as SMC;
use ServerMonitor\Extra as SME;


?>

<section> 

	<h3>&#x1F3E0; Dashboard</h3>

	<div class="widgets-container">
		<?php $temp = new SMC\Temperature(24); $temp->printWidget();?>
		<div class="widget widget-success">
			<div class="title"> <i class="fas fa-lg fa-tint"></i> Room Humidity</div>	
			<div class="content">80%</div>
		</div>
		<div class="widget widget-danger">
			<div class="title"> <i class="fas fa-lg fa-door-closed"></i> Door</div>	
			<div class="content">Closed</div>
		</div>

		<div class="widget widget-warning">
			<div class="title"> <i class="far fa-lg fa-eye"></i> Presence</div>	
			<div class="content">None</div>
		</div>
	</div>

</section>
