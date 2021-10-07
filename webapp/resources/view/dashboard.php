<section> 

	<h3><i class="fas fa-home"></i> Dashboard</h3>

	<div class="control-container">
		<input type="checkbox" class="apple-switch" id="AutoRefresh" checked value="1"> Auto-refresh &nbsp; 
		<span class="timeSince">
			<i class="fas fa-history"></i>
			<span id="TimeSince"><i class="fas fa-circle-notch fa-spin"></i></span>
		</span>
	</div>

	<div class="widgets-container">
		<span class="box bad hide" id="ErrorSensors">
			<i class='fas fa-exclamation-circle'></i> An error has occurred while updating sensors data, retrying soon...
		</span>
		<div id="SensorsContainer">
			&nbsp; Loading sensors.. <i class="fas fa-circle-notch fa-spin"></i><br>
			<?php //showSensorsWidgets(); ?>
		</div>
	</div>

</section>

<script src="resources/view/dashboard.js" async></script>