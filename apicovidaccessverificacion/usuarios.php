<?php

echo 'Informacion solicitada' . file_get_contents('php://input');
switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        echo 'post';
    case 'GET':
        echo "parametro get: ".$_GET['id'];
    
}

?>