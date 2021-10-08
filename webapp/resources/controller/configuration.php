<?php 

if(!empty($_POST)) {
    if (empty($_POST['rawconfig']) || !isValidJson($_POST['rawconfig']))
        echo "The JSON configuration is not valid!";
    else{
        echo editConfiguration($_POST['rawconfig']) ? success("Configuration edited correctly (".date("Y-m-d H:i:s").")") : error("The configuration was not edited correctly, recheck that all the needed variables are present (".date("Y-m-d H:i:s").")");
    }
        
}