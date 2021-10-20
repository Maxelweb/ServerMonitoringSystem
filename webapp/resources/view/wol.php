<section> 

	<h3><i class="fas fa-server"></i> Wake-On-Lan</h3>

	<div class="widgets-container">
		<span class="box bad hide" id="ErrorHardware">
			<i class='fas fa-exclamation-circle'></i> An error has occurred while checking hardware activity, retrying soon...
		</span>
		<span class="box hide" id="MessageHardware">
		</span>
		<div id="HardwareContainer">
            <?php showHardwareWidget(); ?>
		</div>
	</div>

</section>

<script src="resources/view/js/wol.js" async></script>