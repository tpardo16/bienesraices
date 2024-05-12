<?php
    // Conectar la BD
    require "includes/config/database.php";
    $db = conectarDB();


    // Autenticar el usuario
    $errores = [];  // lo ponemos afura para poder acceder en cualquier parte del documento
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        // Sanitizar los datos y validar el email
        $email = mysqli_real_escape_string($db, filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) );
        $password = mysqli_real_escape_string($db, $_POST["password"] );

        if (!$email) {
            $errores[] = "El email es obligatorio o no es valido";
        }

        if (!$password) {
            $errores[] = "El password es obligatorio";
        }

        if (empty($errores)) {
            // Revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '$email'";
            $resultado = mysqli_query($db, $query);

            if ($resultado->num_rows) {
                // Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                
                // Comprobar si las contraseñas coinsiden
                // password_verify( password que el usuario escribio, password de la BD)
                $auth = password_verify($password, $usuario["password"]); // auth -> autenticado
                // var_dump($auth);
                if ($auth) {
                    // El usuario esta autenticado
                    session_start();

                    // Podemos llenar el arreglo de la superglobal como deseemos (darle todo tipo de informacion)
                    // $_SESSION['hola'] = "HOLA"; 
                    $_SESSION['usuario'] = $usuario['email']; // Aqui 'usuario' creo que es un nombre que nosotros le ponemos como 'key'
                    $_SESSION['login'] = true; 

                    header("Location: /admin");

                }
                else {
                    $errores[] = "El password es incorrecto";
                }
            }
            else {
                $errores[] = "El usuario no existe";
            }
        }

    }

    // incluye el header
    require "includes/funciones.php";
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <!-- Mensaje que se muestra -->
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form method="POST" class="formulario" novalidate>
            <fieldset>
                <legend>Email y Password</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" placeholder="Tu Email">

                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Tu Password">
            </fieldset>

            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
        </form>
    </main>

<?php 
    incluirTemplate('footer');
?>