<?php 
    require "../../includes/funciones.php";
    // Esto debe ser lo primero
    $auth = estaAutenticado();

    if (!$auth) {
        header("Location: /");
    }

    // RESUMEN
    // 1. Hay que validar la informacion
    // 2. Saber que informacion es obligatoria
    // 3. Prevenir que se inserten registros a la BD hasta que este correctamente llenado
    // 4. Sanitizar las entradas de los datos (nunca confiar en los usuarios)

    require "../../includes/config/database.php";
    $db = conectarDB();

    // Query para obtener los vendedores
    $consulta = "SELECT * FROM vendedores;";
    $resultado = mysqli_query($db, $consulta); 

    // Arreglo con mensajes de errores
    $errores = [];

    // Ejecuta el código despues de que el usuario envia el formulario
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        // https://www.php.net/manual/es/filter.filters.php
        //  $numero = "1HOLA";
        //  $numero2 = "correo@correo.com/";
        //  $numero3 = 1;
        
        // Sanitizar
        //  $resultado = filter_var($numero, FILTER_SANITIZE_NUMBER_INT);  --> "1"
        //  $resultado = filter_var($numero, FILTER_SANITIZE_STRING);  --> "1HOLA"
        //  $resultado = filter_var($numero2, FILTER_SANITIZE_EMAIL);  --> "correo@correo.com"

        // Validar
        //  $resultado = filter_var($numero3, FILTER_VALIDATE_INT);  --> 1 : bool(false)
        //  $resultado = filter_var($numero2, FILTER_VALIDATE_EMAIL);  --> bool(false) : "correo@correo.com"


        // Sanitizar con mysqli_real_escape_string() para que no afecte el codigo SQL si se pone en el form
        $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
        $precio = mysqli_real_escape_string($db, $_POST['precio']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
        $wc = mysqli_real_escape_string($db, $_POST['wc']);
        $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
        $vendedores_id = mysqli_real_escape_string($db, $_POST['vendedores_id']);
        $creado = date('Y/m/d');
        $imagen = $_FILES["imagen"];  // Asignar files (con toda su informacion) hacia una variable

        if (!$titulo) { $errores[] = 'Debes añadir un titulo'; }
        if (!$precio) { $errores[] = 'El precio es obligatorio'; }
        if (strlen($descripcion) < 10) { $errores[] = 'La descripcion es obligatoria y debe tener al menos 10 caracteres'; }
        if (!$habitaciones) { $errores[] = 'El número de habitaciones es obligatorio'; }
        if (!$wc) { $errores[] = 'El número de baños es obligatorio'; }
        if (!$estacionamiento) { $errores[] = 'El número de estacionamientos es obligatorio'; }
        if (!$vendedores_id) { $errores[] = 'Elige un vendedor'; }
        if (!$imagen["name"] || $imagen["error"]) { $errores[] = 'La imagen es obligatoria'; }

        // $_FILES muestra el tamaño de las imagenes en bytes. 1 kilobytes = 1000 bytes
        /* 
            PHP limita los tamaños de las imagenes por default a 2 megas. 
            Si se sube ej: 4megas por default lo manda a error int(1) y en size int(0) se queda en 0
            Colocar: if (!$imagen["name"] || $imagen["error"]) { $errores[] = 'La imagen es obligatoria'; }
            Incrementar el tamaño varia de plataforma, pero la mejor forma es modificando el archivo php.inie
        */

        // Validar por tamaño (500 kb maximo)
        $medida = 1000 * 500;   //convertir bytes a kilobytes. 500 kb equivale a 500,000 bytes
        if($imagen["size"] > $medida) { $errores[] = 'La imagen es muy pesada'; }

        //echo "<pre>";
        //var_dump($errores);
        //echo "</pre>";

        //exit;   // Va a prevenir la inserccion a la base de datos en caso de error

        // Si el arreglo de errores esta vacio entonces se ejecuta este codigo, si no, no se inserta
        if (empty($errores)) {
            /** SUBIDA DE ARCHIVOS **/
            // Crear carpeta, podemos crear una carpeta con VSC o de esta forma
            $carpetaImagenes = "../../imagenes/"; //ruta relativa
            // usamos un if para que no cree la carpeta una y otra vez. is_dir() nos dice si una carpeta existe o no
            if (!is_dir($carpetaImagenes)) {    
                mkdir($carpetaImagenes);    // mkdir - crear un directorio/carpeta en la ruta dada
            }

            // Generar un nombre único
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

            // Subir la imagen
            //tmp_name es donde se guarda temporalmente la imagen
            //para mover la imagen de la memoria del servidor hacia la carpeta imagenes:
            move_uploaded_file($imagen["tmp_name"], $carpetaImagenes . $nombreImagen); //(nombre del archivo/el nombre temporal, la carpeta donde lo vamos a colocar y el nombre que va a tener)
            /*--------------------------------------------------------------------------------------------*/
            $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id) VALUES ('$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedores_id');";

            // echo $query;
    
            $resultado = mysqli_query($db, $query);
    
            if ($resultado) {
                //echo "exitoso";
                // Redireccionar al usuario para evitar que esten duplicando entradas
                header('Location: /admin?resultado=1'); // Sirve para enviar datos y redireccionar, recomendacion: ruta absoluta
            }                               // SOLO FUNCIONA SI NO HAY HTML PREVIO. Intentar usar pocas redirecciones
        }
    }

    // require "../../includes/funciones.php";  No puedes tener 2 veces el require
    // Header
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <!-- Cuando un formulario quiere subir archivos hay que colocarle: enctype="multipart/form-data"-->
        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo: </label>
                <input type="text" id="titulo" name="titulo" value="<?php echo $titulo; ?>" placeholder="Titulo de la Propiedad">

                <label for="precio">Precio: </label>
                <input type="number" id="precio" name="precio" value="<?php echo $precio; ?>" placeholder="Precio de la Propiedad">

                <!-- Las imagenes y los archivos no se leen con $_POST, se leen con $_FILES-->
                <label for="imagen">Imagen: </label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">

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
                    <?php while($vendedor = mysqli_fetch_assoc($resultado)): ?> <!-- Me devuelve el primer registro. while() itera todos-->
                        <option <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>" ><?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                    <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php 
    incluirTemplate('footer');
?>