<?php 

if(!empty($_POST)) {
    if (empty($_POST['rawconfig']) || !isValidJson($_POST['rawconfig']))
        echo "The JSON configuration is not valid!";
    else 
        editConfiguration($_POST['rawconfig']); 
}