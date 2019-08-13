<?php


?>

<section> 

	<h3>&#x1F3E0; Dashboard</h3>

	<div class="widgets-container">
		<?php $temp = new Temperature(24); $temp->printWidget();?>
		<?php $humi = new Humidity(70); $humi->printWidget();?>
		<?php $door = new Door(0); $door->printWidget();?>
		<?php $light = new Light(0); $light->printWidget();?>
		<?php $ha = new HardwareActivity($_platforms); $ha->printWidget();?>
	</div>

</section>
