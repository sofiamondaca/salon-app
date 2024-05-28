<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController 
{
    public static function index(Router $router){
        session_start();

        isAdmin();

        // Si no se ha escogido una fecha mediante el input
        // Genera una fecha del servidor, que sera e dia de hoy
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);


        if (!checkdate($fechas[1], $fechas[2], $fechas[0])) {
            header('Location: /404');
        }


        // Consultar la base de datos
        $query = "SELECT citas.id, citas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) as cliente, usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio ";
        $query .= " FROM citas ";
        $query .= " LEFT OUTER JOIN usuarios";
        $query .= " ON citas.usuarioId = usuarios.id ";
        $query .= " LEFT OUTER JOIN citasservicios ";
        $query .= " ON citasservicios.citaId=citas.id ";
        $query .= " LEFT OUTER JOIN servicios ";
        $query .= " ON servicios.id = citasservicios.servicioId ";
        $query .= " WHERE fecha= '$fecha' ";

        $citas = AdminCita::SQL($query);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}
