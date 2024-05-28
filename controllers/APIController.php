<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController 
{
    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar(){

        $cita = new Cita($_POST);
        // // Almacena la cita y devuelve el id
        // // Resultado tiene un id
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        // Almacena los servicios con el ID de la cita
        // Los datos son enviados en el arhivo JS con datos.append
        // explode es el equivalente de PHP a split
        // los servicios se traen como { 1, 3 ,4 etc } por lo que se separan por comas
        $idServicios = explode(",", $_POST['servicios']);

        // Guarda los servicios con las referencias de las citas
        foreach ($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];

            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $cita = Cita::find($id);
            $cita->eliminar();
            // HTTP REFERER es la pagina de donde viene el usuari
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }

}
