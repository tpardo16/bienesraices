<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    $auth = $_SESSION['login'] ?? false;

    // var_dump($auth);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/build/css/app.css">  <!-- Si le ponemos al principio / al href buscara desde la raiz la carpeta build-->
</head>
<body>

    <header class="header <?php echo $variable ? 'inicio' : ''; ?>">  <!-- Por ejemplo en nosotros.php la variable $variable no esta definida lo que muestra un error, entonce usamos isset() que revisa si una variable esta creada [ echo isset($variable) ? 'inicio' : ''; ]-->
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="/build/img/logo.svg" alt="logotipo de bienes raices">
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu resposive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg">
                    <nav class="navegacion">
                        <a href="/nosotros.php">Nosotros</a>
                        <a href="/anuncios.php">Anuncios</a>
                        <a href="/blog.php">Blog</a>
                        <a href="/contacto.php">Contacto</a>
                        <?php if ($auth): ?>
                            <a href="/cerrar-sesion.php">Cerrar Sesion</a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>

            <?php if ($variable) { ?>
                <h1>Venta de Casas y Departamento Exclusivos de Lujo</h1>
            <?php } ?>
        </div>
    </header>