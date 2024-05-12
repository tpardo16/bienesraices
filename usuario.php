<?php
// Requerimos crear un usuario al menos para poder autenticar 
// Una vez que llevemos el trabajo a produccion hay que eliminar este archivo

/*
    PASOS
    1. Importar la BD
    2. Crear un email y password
    3. Query para crear el usuario
    4. Agregarlo a la BD
*/

require "includes/config/database.php";
$db = conectarDB();

$email = "correo@correo.com";
$password = "123456";

// La funcion md5() ya no se recomienda para hashear ni nada relacionado con la seguridad

$passwordHash = password_hash($password, PASSWORD_DEFAULT);  // tambien esta PASSWORD_BCRYPT
// Nos da una extension fija de String(60) por eso es la BD usamos char(60)
// ya que Varchar no es obligatorio usar todos los caracteres especificados
// ej: varchar(11) puede solamente almacenar 2 caracteres

// var_dump($passwordHash);

$query = "INSERT INTO usuarios (email, password) VALUES ('$email', '$passwordHash')";

// echo $query;

mysqli_query($db, $query);