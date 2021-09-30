<section> 

	<h3>Edit configuration</h3>

	<div class="widgets-container">
        <form action="?" method="post">
            <textarea required name="rawconfig" rows="15" cols="5"><?= json_encode($_config); ?></textarea>

            <button type="submit">Save</button>
        </form>
	</div>

</section>