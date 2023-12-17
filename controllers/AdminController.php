<?php


namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index( Router $router){

    $fecha = $_GET['fecha'] ?? date('Y-m-d');
    $fechas = explode('-',$fecha);
    
    isAdmin();

    if(!checkdate ($fechas[1], $fechas[2],$fechas[0])){
        header('Location: /404'); 
    }

    //consultar base de datos
      $consulta = "SELECT cita.id, cita.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM cita  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON cita.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasservicios ";
        $consulta .= " ON citasservicios.citaId=cita.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasservicios.servicioId ";
       $consulta .= " WHERE fecha =  '${fecha}'";
  
        $citas = AdminCita::SQL($consulta);
 
    $router->render('admin/index', [
        'nombre' => $_SESSION['nombre'],
        'citas' =>$citas,
        'fecha'=>$fecha

    ]);
}

    }