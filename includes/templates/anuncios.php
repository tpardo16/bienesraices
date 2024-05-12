<?php
    // Conectarse
    //require 'includes/config/database.php';   Si funciona
    //require '../config/database.php';         No funciona. El archivo lo manda a llamar el index
    //                                          por lo que la ruta a este require debe ser relativa al index
    require __DIR__ . '/../config/database.php';
    $db = conectarDB();

    // Hacer la consulta
    $query = "SELECT * FROM propiedades LIMIT $limite";

    // Ejecutar el query
    $resultado = mysqli_query($db, $query);

?>

<div class="contenedor-anuncios">

    <?php while ($propiedad = mysqli_fetch_assoc($resultado)): ?>
        <div class="anuncio">
            
            <img src="imagenes/<?php echo $propiedad['imagen']; ?>" alt="anuncio" loading="lazy">
            
            <div class="contenido-anuncio">
                <h3><?php echo $propiedad['titulo']; ?></h3>
                <p><?php echo $propiedad['descripcion']; ?></p>
                <p class="precio">$<?php echo $propiedad['precio']; ?></p>

                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" src="build/img/icono_wc.svg" alt="icono wc" loading="lazy">
                        <p><?php echo $propiedad['wc']; ?></p>
                    </li>

                    <li>
                        <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento" loading="lazy">
                        <p><?php echo $propiedad['estacionamiento']; ?></p>
                    </li>

                    <li>
                        <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono habitaciones" loading="lazy">
                        <p><?php echo $propiedad['habitaciones']; ?></p>
                    </li>
                </ul>

                <a href="anuncio.php?id=<?php echo $propiedad['id']; ?>" class="boton boton-amarillo-block">Ver Propiedad</a>
            </div><!--.contenido-anuncio-->
        </div><!--.anuncio-->
    <?php endwhile; ?>

</div><!--.contenedor-anuncios-->

<?php mysqli_close($db); ?>