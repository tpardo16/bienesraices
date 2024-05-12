<?php

function conectarDB() : mysqli {
    $db = mysqli_connect('localhost', 'root', '123', 'bienesraices_crud');

    if(!$db) {
        echo "Hubo un error";
        exit;   //se encarga que las demas lineas no se ejecuten
    }           //cuando hay un error puede revelarse informacion sensible, por eso detenemos la ejecucion

    return $db;
}