<section>
	<h3>&#x1F4B9; Real-time Charts</h3>

	<!-- Add average temp / hum -->

	<div class="control-container">
		<input type="checkbox" class="apple-switch" id="AutoRefresh" checked value="1"> Enable refresh 
	</div>

	<div class="charts-container">
		<span class="box bad hide" id="Error">
			<i class='fas fa-exclamation-circle'></i> An error has occurred while updating charts, retrying soon...
		</span>
		
		Average temperature: <span id="AvgTemp"></span>

		Average humidity: <span id="AvgHumi"></span>

		<canvas id="TempChart"></canvas>

		<canvas id="HumiChart"></canvas>
	</div>

</section>

<script src="resources/realtime.js" async></script>