<section>
	<h3>&#x1F4B9; Real-time Charts</h3>
	

	<div class="control-container">
		<input type="checkbox" class="apple-switch" id="AutoRefresh" checked value="1"> Enable refresh 
	</div>

	<div class="charts-container">
		<span class="box bad hide" id="Error">
			<i class='fas fa-exclamation-circle'></i> An error has occurred while updating charts, retrying soon...
		</span>
		
		<canvas id="myChart" width="400" height="400"></canvas>
	</div>

</section>

<script src="resources/realtime.js" async></script>