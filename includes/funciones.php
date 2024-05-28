<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo($actual, $proximo) : bool{
    if ($actual !== $proximo) {
        // Es el ultimo servicio de la cita
        return true;
    } else {
        return false;
    }
}


// Funcion que revisa que el usuario esta autenticado
// Comprobar variable creada en el servidor a traves de $_Session
function isAuth() : void{
    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

function isAdmin() : void{
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}
