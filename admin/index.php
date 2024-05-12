<?php 
    require "../includes/funciones.php";
    // Esto debe ser lo primero
    $auth = estaAutenticado();

    if (!$auth) {
        header("Location: /");
    }

    //session_start();

    // echo "<pre>";
    // var_dump($_SESSION);
    // echo "</pre>";

    // $auth = $_SESSION['login'];

    // if (!$auth) {
    //     header("Location: /");
    // }

    // Importando la BD para listar las propiedades
    require "../includes/config/database.php";
    $db = conectarDB();

    $query = "SELECT * FROM propiedades;";

    $resultadoConsulta = mysqli_query($db, $query);


    // Muestra mensaje condicional
    $resultado = $_GET["resultado"] ?? null;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validacion
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if ($id) {
            // Eliminar el archivo
            $query = "SELECT imagen FROM propiedades WHERE id = $id";
            $resultado = mysqli_query($db, $query);
            $propiedad = mysqli_fetch_assoc($resultado);
            
            unlink('../imagenes/' . $propiedad['imagen']);

            // Eliminar la propiedad
            $query = "DELETE FROM propiedades WHERE id = $id";
            $resultado = mysqli_query($db, $query);

            if ($resultado) {
                header('Location: /admin?resultado=3');
            }
        }
    }

    // Header
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php if (intval($resultado) === 1):?>
            <p class="alerta exito">Anuncio creado correctamente</p>
        <?php elseif (intval($resultado) === 2):?>
            <p class="alerta exito">Anuncio actualizado correctamente</p>
        <?php elseif (intval($resultado) === 3):?>
            <p class="alerta exito">Anuncio eliminado correctamente</p>
        <?php endif; ?>

        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!-- Mostrar los resultados-->
                <?php while ($propiedad = mysqli_fetch_assoc($resultadoConsulta)): ?>
                <tr>
                    <th><?php echo $propiedad['id']; ?></th>
                    <th><?php echo $propiedad['titulo']; ?></th>
                    <th><img src="/imagenes/<?php echo $propiedad['imagen']; ?>" class="imagen-tabla"></th>
                    <th>$<?php echo $propiedad['precio']; ?></th>
                    <th>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">Actualizar</a>
                    </th>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

<?php 
    // Cerrar la conexion
    mysqli_close($db);
    
    incluirTemplate('footer');
?>