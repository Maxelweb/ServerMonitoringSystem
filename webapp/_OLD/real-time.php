<section>
	<h3>&#x1F4B9; Real-time Charts</h3>

	<div class="control-container">
		<input type="checkbox" class="apple-switch" id="AutoRefresh" checked value="1"> Enable refresh 
	</div>

	<div class="charts-container">
		<span class="box bad hide" id="Error">
			<i class='fas fa-exclamation-circle'></i> An error has occurred while updating charts, retrying soon...
		</span>
		
		<span class="box">
			<strong><i class="fas fa-thermometer-half"></i> Avg. temperature:</strong> <span id="AvgTemp"><i class="fas fa-circle-notch fa-spin"></i> </span>° C
		<br><br>
			<strong><i class="fas fa-tint"></i> Avg. humidity:</strong> <span id="AvgHumi"><i class="fas fa-circle-notch fa-spin"></i> </span>%
		</span>

		<canvas id="TempChart"></canvas>

		<canvas id="HumiChart"></canvas>
	</div>

</section>

<script src="resources/realtime.js" async></script>