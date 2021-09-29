<section> 

	<h3>Edit configuration</h3>

    <?php 
        if(isset($_POST)) {
            if (empty($rawconfig) || !isValidJson($rawconfig))
                echo "The JSON configuration is not valid!";
            else 
                editConfiguration($_POST['rawconfig']); 
        }
    ?>

	<div class="widgets-container">
        <form action="?" method="post">
            <textarea required name="rawconfig" rows="15" cols="5"><?= json_encode($_config); ?></textarea>

            <button type="submit">Save</button>
        </form>
	</div>

</section>