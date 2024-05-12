<?php 
    require "../../includes/funciones.php";
    // Esto debe ser lo primero
    $auth = estaAutenticado();

    if (!$auth) {
        header("Location: /");
    }


    // Validar que sea un id valido
    $id = $_GET["id"];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if (!$id) {
        header("Location: /admin");
    }

    require "../../includes/config/database.php";
    $db = conectarDB();

    $consulta = "SELECT * FROM propiedades WHERE id = $id;";
    $resultado = mysqli_query($db, $consulta);
    $propiedad = mysqli_fetch_assoc($resultado);

    // echo "<pre>";
    // var_dump($propiedad);
    // echo "</pre>";

    $consulta = "SELECT * FROM vendedores;";
    $resultado = mysqli_query($db, $consulta); 

    // Arreglo con mensajes de errores
    $errores = [];

    $titulo = $propiedad["titulo"];
    $precio = $propiedad["precio"];
    $descripcion = $propiedad["descripcion"];
    $habitaciones = $propiedad["habitaciones"];
    $wc = $propiedad["wc"];
    $estacionamiento = $propiedad["estacionamiento"];
    $vendedores_id = $propiedad["vendedores_id"];
    // Por seguridad no se debe llenar la imagen por que revela la ubicación de los archivos en el servidor
    // Pero si podemos poner la imagen en el formulario
    $imagenPropiedad = $propiedad["imagen"];

    // Ejecuta el código despues de que el usuario envia el formulario
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
        $precio = mysqli_real_escape_string($db, $_POST['precio']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
        $wc = mysqli_real_escape_string($db, $_POST['wc']);
        $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
        $vendedores_id = mysqli_real_escape_string($db, $_POST['vendedores_id']);
        $creado = date('Y/m/d');
        $imagen = $_FILES["imagen"];  

        if (!$titulo) { $errores[] = 'Debes añadir un titulo'; }
        if (!$precio) { $errores[] = 'El precio es obligatorio'; }
        if (strlen($descripcion) < 10) { $errores[] = 'La descripcion es obligatoria y debe tener al menos 10 caracteres'; }
        if (!$habitaciones) { $errores[] = 'El número de habitaciones es obligatorio'; }
        if (!$wc) { $errores[] = 'El número de baños es obligatorio'; }
        if (!$estacionamiento) { $errores[] = 'El número de estacionamientos es obligatorio'; }
        if (!$vendedores_id) { $errores[] = 'Elige un vendedor'; }

        $medida = 1000 * 500;  
        if($imagen["size"] > $medida) { $errores[] = 'La imagen es muy pesada'; }

   
        if (empty($errores)) {
            /** SUBIDA DE ARCHIVOS **/

            // Crear carpeta
            $carpetaImagenes = "../../imagenes/"; 

            if (!is_dir($carpetaImagenes)) {    
                mkdir($carpetaImagenes);    
            }

            $nombreImagen = '';

            // Borrar la imagen anterior si se coloca otra
            if ($imagen['name']) {
                //echo "Hay una nueva imagen";
                // Eliminar la imagen previa
                // nota: para crear archivos usamos move_uploaded_file() y para eliminarlos unlink()
                unlink($carpetaImagenes . $propiedad["imagen"]);

                // Generar un nombre único
                $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";
    
                move_uploaded_file($imagen["tmp_name"], $carpetaImagenes . $nombreImagen);
            }
            else {
                //echo "No hay una nueva imagen";
                $nombreImagen = $propiedad["imagen"];
            }



            /*--------------------------------------------------------------------------------------------*/
            $query = "UPDATE propiedades SET titulo = '$titulo', precio = '$precio', imagen = '$nombreImagen', descripcion = '$descripcion', habitaciones = $habitaciones, wc = $wc, estacionamiento = $estacionamiento, vendedores_id = $vendedores_id WHERE id = $id;";
    

            $resultado = mysqli_query($db, $query);
    
            if ($resultado) {
                header('Location: /admin?resultado=2'); 
            }                              
        }
    }

    // Header
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Actualizar</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <!-- Si no ponemos action="" el formulario lo va a enviar al mismo archivo-->
        <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo: </label>
                <input type="text" id="titulo" name="titulo" value="<?php echo $titulo; ?>" placeholder="Titulo de la Propiedad">

                <label for="precio">Precio: </label>
                <input type="number" id="precio" name="precio" value="<?php echo $precio; ?>" placeholder="Precio de la Propiedad">

                <!-- Las imagenes y los archivos no se leen con $_POST, se leen con $_FILES-->
                <label for="imagen">Imagen: </label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">
                <img src="/imagenes/<?php echo $imagenPropiedad; ?>" class="imagen-small">

                <label for="descripcion">Descripción: </label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Información Propiedad</legend>

                <label for="habitaciones">Habitaciones: </label>
                <input type="number" id="habitaciones" name="habitaciones" value="<?php echo $habitaciones; ?>" placeholder="Ej: 3" min="1" max="9">

                <label for="wc">Baños: </label>
                <input type="number" id="wc" name="wc" value="<?php echo $wc; ?>" placeholder="Ej: 3" min="1" max="9">

                <label for="estacionamiento">Estacionamientos: </label>
                <input type="number" id="estacionamiento" name="estacionamiento" value="<?php echo $estacionamiento; ?>" placeholder="Ej: 3" min="1" max="9">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedores_id">
                    <option value="">-- Seleccione --</option>
                    <?php while($vendedor = mysqli_fetch_assoc($resultado)): ?> 
                        <option <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>" ><?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                    <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php 
    incluirTemplate('footer');
?>