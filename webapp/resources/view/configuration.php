<section> 

	<h3><i class="fas fa-edit"></i> Edit configuration</h3>

	<div class="widgets-container">
        <form action="?s=config" method="post">
        <p id="jsonValid"><span class='good'>Json is VALID</span></p>
        <textarea required name="rawconfig" id="editConfig" onkeyup="updateJsonStatus(isValidJson(this.value));" rows="15"><?= json_encode($_config); ?></textarea>

            <button type="submit" id="saveRaw">Save</button>
        </form>
	</div>


</section>

<script src="resources/view/configuration.js" async></script>