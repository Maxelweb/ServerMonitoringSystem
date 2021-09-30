<?php 

    if(isset($_POST)) {
        if (empty($rawconfig) || !isValidJson($rawconfig))
            echo "The JSON configuration is not valid!";
        else 
            editConfiguration($_POST['rawconfig']); 
    }