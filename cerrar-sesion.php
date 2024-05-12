<?php
session_start();

// Para eliminar la SESSION existen las funciones "session_unset()" y "session_destroy()"
// Pero nosotros vamos a reiniciar el array de SESSION a un arry vacio

$_SESSION = [];

header("Location: /");