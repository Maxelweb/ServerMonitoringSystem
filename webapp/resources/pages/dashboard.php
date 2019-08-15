<?php


?>

<section> 

	<h3>&#x1F3E0; Dashboard</h3>

	<div class="control-container">
		<input type="checkbox" class="apple-switch" id="AutoRefresh" checked value="1"> Auto-refresh &nbsp; 
		<span class="timeSince">
			<i class="fas fa-history"></i>
			<span id="TimeSince">now</span>
		</span>
	</div>

	<div class="widgets-container">
		<div id="SensorsContainer">
			<?php showWidgets();?>
		</div>
		<div id="HardwareContainer">
			<?php $ha = new HardwareActivity($_platforms); $ha->printWidget();?>
		</div>
	</div>

</section>
