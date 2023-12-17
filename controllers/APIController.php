<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController{

    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);

    }

public static function guardar(){
    
//almacena la cita y devuelve el id
    $cita = new Cita($_POST);
    $resultado = $cita->guardar();

    $id = $resultado['id'];

//almacena los servicios con el id de la cita

    $idServicios =  explode(",", $_POST['servicios']);
    foreach($idServicios as $idServicio){
        $args = [
             'citaId' => $id,
             'servicioId' => $idServicio   
                    ];
     $citaServicio = new CitaServicio($args);
     $citaServicio-> guardar();
    }
   
    //retornamos una respuesta
   
        echo json_encode(['resultado' => $resultado]);
    }
public static function eliminar(){
    //nos aseguramos que solo se ejecute en metodo post
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //leemos el id
        $id = $_POST['id'];
        //buscamos la instacia de la cita con ese id
        $cita = Cita::find($id);
        //eliminamos la cita con ese id
        $cita->eliminar();
        //redireccionamos hacía donde estabamos
        header('Location:'. $_SERVER['HTTP_REFERER'],);
    }
}
}
?>