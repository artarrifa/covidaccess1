<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";


class sintomas extends conexion {

    private $table = "sintomas";
    private $sintomasId = "";
    private $usuarioId = "";
    private $fechaRegistro = "0000-00-00";
    private $fatiga = "";
    private $dolorMuscular = "";
    private $escalofrios = "";
    private $dolorDeCabeza = "";
    private $diarrea = "";
    private $dolorDeGarganta = "";
    private $perdidaGusto = "";
    private $nauseas = "";
    private $diagnosticoCovid = "0000-00-00";
    private $sospechaCovid = "";
    private $otraEnfermedad = "";
    private $tengoIncapacidad = "";
    private $alta = "";
    private $normal = "";
    private $confirmacionSalud = "";
     
    private $token = "";
//912bc00f049ac8464472020c5cd06759

    public function listasintomas($pagina = 1){
        $inicio  = 0 ;
        $cantidad = 100;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina - 1)) +1 ;
            $cantidad = $cantidad * $pagina;
        }
        $query = "SELECT sintomasId,usuarioId,fechaRegistro,confirmacionSalud,sospechaCovid FROM " . $this->table . " limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

    public function obtenerSintomas($id){
        $query = "SELECT sintomasId,usuarioId,fechaRegistro,confirmacionSalud,sospechaCovid FROM " . $this->table . " WHERE usuarioId = '$id'";
        return parent::obtenerDatos($query);

    }

    public function post($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['token'])){
                return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if($arrayToken){
            //se leen datos si viene el token y se valida con la accion de read
              $id=$datos['usuarioId'];
            if($datos['action']==="read"){
                 
                $query = "SELECT sintomasId,usuarioId,fechaRegistro,confirmacionSalud,sospechaCovid FROM " . $this->table . " WHERE usuarioId = '$id'";
                return parent::obtenerDatos($query);
                header("Content-Type: application/json");
                echo json_encode($datosSintomas);
                http_response_code(200);
                 
            }
                if(!isset($datos['usuarioId']) || !isset($datos['fechaRegistro']) || !isset($datos['sospechaCovid']) || !isset($datos['confirmacionSalud']) ){
                    return $_respuestas->error_400();
                }else{
                    $this->usuarioId = $datos['usuarioId'];
                    $this->fechaRegistro = $datos['fechaRegistro'];
                    $this->sospechaCovid = $datos['sospechaCovid'];
                    $this->confirmacionSalud = $datos['confirmacionSalud'];
                    $resp = $this->insertarSintomas();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "sintomasId" => $resp
                        );
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }

            }else{
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
        }


       

    }


    private function insertarSintomas(){
        $query = "INSERT INTO " . $this->table . " (usuarioId,fechaRegistro,sospechaCovid, confirmacionSalud)
        values
        ('" . $this->usuarioId . "','" . $this->fechaRegistro . "','" . $this->sospechaCovid ."','" . $this->confirmacionSalud . "')"; 
        $resp = parent::nonQueryId($query);
        if($resp){
             return $resp;
        }else{
            return 0;
        }
    }
    
    public function put($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['token'])){
            return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if($arrayToken){
                if(!isset($datos['sintomasId'])){
                    return $_respuestas->error_400();
                }else{
                    $this->sintomasId = $datos['sintomasId'];
                    if(isset($datos['usuarioId'])) { $this->usuarioId = $datos['usuarioId']; }
                    if(isset($datos['fechaRegistro'])) { $this->fechaRegistro = $datos['fechaRegistro']; }
                    if(isset($datos['sospechaCovid'])) { $this->sospechaCovid = $datos['sospechaCovid']; }
                    if(isset($datos['confirmacionSalud'])) { $this->confirmacionSalud = $datos['confirmacionSalud']; }
                    
                    $resp = $this->modificarPaciente();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "sintomasId" => $this->sintomasId
                        );
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }

            }else{
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
        }


    }


    private function modificarPaciente(){
        $query = "UPDATE " . $this->table . " SET Nombre ='" . $this->nombre . "',Direccion = '" . $this->direccion . "', DNI = '" . $this->dni . "', CodigoPostal = '" .
        $this->codigoPostal . "', Telefono = '" . $this->telefono . "', Genero = '" . $this->genero . "', FechaNacimiento = '" . $this->fechaNacimiento . "', Correo = '" . $this->correo .
         "' WHERE sintomasId = '" . $this->sintomasId . "'"; 
        $resp = parent::nonQuery($query);
        if($resp >= 1){
             return $resp;
        }else{
            return 0;
        }
    }


    public function delete($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);


        if(!isset($datos['token'])){
            return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if($arrayToken){

                if(!isset($datos['sintomasId'])){
                    return $_respuestas->error_400();
                }else{
                    $this->sintomasId = $datos['sintomasId'];
                    $resp = $this->eliminarSintomas();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "sintomasId" => $this->sintomasId
                        );
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }

            }else{
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
        }



     
    }


    private function eliminarSintomas(){
        $query = "DELETE FROM " . $this->table . " WHERE sintomasId= '" . $this->sintomasId . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1 ){
            return $resp;
        }else{
            return 0;
        }
    }


    private function buscarToken(){
        $query = "SELECT  tokenId,usuarioId,estado from usuariosToken WHERE tokenUsuarios = '" . $this->token . "' AND estado = 'Activo'";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }


    private function actualizarToken($tokenid){
        $date = date("Y-m-d H:i");
        $query = "UPDATE usuarios_token SET Fecha = '$date' WHERE TokenId = '$tokenid' ";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
    }



}





?>