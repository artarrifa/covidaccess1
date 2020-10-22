<?php
require_once "clases/conexion/conexion.php";
echo ("prueba conexion");
$conexion = new conexion;
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API - Prubebas</title>
    <link rel="stylesheet" href="assets/estilo.css" type="text/css">
</head>
<body>

<div  class="container">
    <h1>Api de Sintomas</h1>
    http://covidaccess.com.co/apicovidaccessverificacion/terminosycondicionescovidpass.html
    
    <a href="http://www.covidpass.com.co/coviddata/terminosycondicionescovidpass.html">Terminos y Condiciones</a>
    <div class="divbody">
        <h3>Auth - login</h3>
        <code>
           POST  /auth   con estos datos piden el token para hacer la funcion de insercion
           <br>
           http://covidaccess.com.co/apicovidaccessverificacion/auth
           <br>
           {
               <br>
               "usuario" :"",  -> REQUERIDO
               <br>
               "password": "" -> REQUERIDO
               <br>
            }
            
            <br>
            Ejemplo
            <br>
            {
               "numeroId" : "123456", <br>
                "password" : "123456"
                }
            
        <br>
        Respuesta esperada
        <br>
        {
             "status": "ok",<br>
             "result": {<br>
             "token": "a11c558d603dcfda221a4e4159b7b556"<br>
             }<br>
            }<br>
        </code>
    </div>      
    <div class="divbody">   
        <h3>Sintomas</h3>
        <code>
           
           <br>
           GET  /sintomas?id=$id
           <br>
           ejemplo http://covidaccess.com.co/apicovidaccessverificacion/sintomas1?id=4
        </code>

        <code>
           POST  /sintomas
           http://covidaccess.com.co/apicovidaccessverificacion/sintomas1
           <br> 
           {
            <br>   Ejemplo
            <br> 
                "usuarioId" : 777,  
                <br>  
                "fechaRegistro" : "2020-09-09",  
                <br>  
                 "sospechaCovid":"on",  
                 <br>  
                "confirmacionSalud" :"on",
                <br>  
                 "token" : "c2163a48f685db85019bbd18174cd22c"  
               
               <br>       
           }

        </code>
        
         <code>
             Lectura con token
           POST  /sintomas1
           http://covidaccess.com.co/apicovidaccessverificacion/sintomas1
           <br> 
           {
            <br>   Ejemplo
            <br> 
                {<br> 
                    "usuarioId" : 20,<br> 
            "token" : "c2163a48f685db85019bbd18174cd22c",<br> 
            "action" : "read"<br> 
            }
                <br>  
                

        </code>
        
         <div class="divbody">   
        <h3>Registro Sintomas </h3>
        
        <code>
           POST  /sintomas1
          http://covidaccess.com.co/apicovidaccessverificacion/sintomas1
           <br> 
          
            <br>   Ejemplo<br> 
             {
            <br> 
                "usuarioId" : 999,  
                <br>  
                "fechaRegistro" : "2020-09-09",  
                <br>  
                 "sospechaCovid":"on",  
                 <br>  
                "confirmacionSalud" :"on",
                <br>  
                 "token" : "c2163a48f685db85019bbd18174cd22c"  
               
               <br>       
           }

        </code>
        
    </div>


</div>
    
</body>
</html>

