<?php 
    require "includes/funciones.php";
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado ">
        <h1>Guía para la decoración de tu hogar</h1>
        
        <picture>
            <source srcset="build/img/destacada2.webp" type="image/webp">
            <source srcset="build/img/destacada2.jpg" type="image/jpeg">
            <img src="build/img/destacada2.jpg" alt="imagen de la propiedad" loading="lazy">
        </picture>
        
        <p class="informacion-meta">Escrito el: <span>20/10/2021</span> por: <span>Admin</span></p>

        <div class="resumen-propiedad">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, odit? Corrupti atque omnis explicabo expedita eos asperiores provident nulla. Culpa asperiores voluptatum aliquid laboriosam alias, qui totam fuga excepturi dolores! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam reprehenderit eligendi minus neque, tenetur aliquid molestias! Cupiditate ab soluta ex perferendis repellendus assumenda dolores pariatur, facere quasi dicta quas corrupti. Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti quaerat quidem magni! Modi, ipsa placeat. Commodi blanditiis odit provident, amet dolor incidunt adipisci rem, totam labore consequatur ea atque iure?</p>

            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Labore a illum temporibus neque ut sed earum eveniet voluptate ex perferendis soluta rem non laudantium eum aliquam, maxime sint, quam dolorum.</p>
        </div>
    </main>

<?php 
    incluirTemplate('footer');
?>