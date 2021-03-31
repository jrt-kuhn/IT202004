<?php
function is_empty_or_null($variable){
    return !isset($variable) || empty($variable);
}

function setDebug($data){
    $_SESSION["debug"] = $data;
}

function getDebug($dumpAll = false){
    if(isset($_SESSION["debug"]) && !$dumpAll){
        
        echo var_export($_SESSION["debug"], true);
        unset($_SESSION["debug"]);
    }
    else{
        echo var_export($_SESSION, true);
    }
}
?>
