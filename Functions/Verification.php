<?php
// Verifier si la variable $_POST ou $_GET sont definit: contient des valeurs
// 
function verificate($globalVariable,$variables){
    $isDefine = false;
    foreach($variables as $elem){
        if(isset($globalVariable[$elem])){
            $isDefine = true;
        }else {
            return false;
        }
    } 
    return $isDefine;
}

?>