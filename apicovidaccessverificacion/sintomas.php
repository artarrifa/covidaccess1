
<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/sintomas.class.php';

$_respuestas = new respuestas;
$_sintomas = new sintomas;


if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["page"])){
        $pagina = $_GET["page"];
        $listasintomas = $_sintomas->listasintomas($pagina);
        header("Content-Type: application/json");
        echo json_encode($listasintomas);
        http_response_code(200);
    }else if(isset($_GET['id'])){
        $sintomas_id = $_GET['id'];
        $datosSintomas = $_sintomas->obtenerSintomas($sintomas_id);
        header("Content-Type: application/json");
        echo json_encode($datosSintomas);
        http_response_code(200);
    }
    
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos los datos al manejador
    $datosArray = $_sintomas->post($postBody);
    //delvovemos una respuesta 
     header('Content-Type: application/json');
     if(isset($datosArray["result"]["error_id"])){
         $responseCode = $datosArray["result"]["error_id"];
         http_response_code($responseCode);
     }else{
         http_response_code(200);
     }
     echo json_encode($datosArray);
    
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
      //recibimos los datos enviados
      $postBody = file_get_contents("php://input");
      //enviamos datos al manejador
      $datosArray = $_sintomas->put($postBody);
        //delvovemos una respuesta 
     header('Content-Type: application/json');
     if(isset($datosArray["result"]["error_id"])){
         $responseCode = $datosArray["result"]["error_id"];
         http_response_code($responseCode);
     }else{
         http_response_code(200);
     }
     echo json_encode($datosArray);

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
echo("metod delete");
     $headers = getallheaders();
     if(isset($headers['token']) && isset($headers['sintomas_id'])){
        $send = [
            "token" => $headers['token'],
            "sintomas_id" => $headers['sintomas_id']
        ];
         $postBody = json_encode($send);
     }else{
         $postBody = file_get_contents("php://input");
     }

    //enviamos datos al manejador
    $datosArray = $_sintomas->delete($postBody);
    //delvovemos una respuesta 
       header('Content-Type: application/json');
       if(isset($datosArray["result"]["error_id"])){
            echo json_encode($datosArray);  $responseCode = $datosArray["result"]["error_id"];
            http_response_code($responseCode);
       }else{
            http_response_code(200);
       }

}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}


?>