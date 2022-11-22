<?php
require_once("enviroment.php");

$json = file_get_contents('php://input'); //Lectura de POST (que no vienen de un formulario)
$post = json_decode($json); //Conversion de json a object.

if($post!=null && $post->id!=null && $post->email!=null)  //Verificamos si el objeto, y los atributos(si es que lo tiene) no son nulos.
{
    if(!$serverStatus)
    {
        $id = $post->id;
        $email=$post->email;
        
        $sql= $DB->query("call seArticulo('$id','$email')");

        if($request= $sql->fetch_object())
        {
            http_response_code(200); //Todo salio bien.
            echo json_encode($request);
        }
        else
        {
        http_response_code(404); //No se encontraron articulos
        }
    }
    else
    {
        http_response_code(500); //Error de server
    }
}
else
{
    http_response_code(400); //Datos corruptos.
}

$DB->close();

?>