<?php 
    require "includes/funciones.php";
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Conoce sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                    <img src="build/img/nosotros.jpg" alt="sobre nosotros" loading="lazy">
                </picture>
            </div>

            <div class="texto-nosotros">
                <blockquote>
                    25 Años de experiencia
                </blockquote>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, odit? Corrupti atque omnis explicabo expedita eos asperiores provident nulla. Culpa asperiores voluptatum aliquid laboriosam alias, qui totam fuga excepturi dolores! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam reprehenderit eligendi minus neque, tenetur aliquid molestias! Cupiditate ab soluta ex perferendis repellendus assumenda dolores pariatur, facere quasi dicta quas corrupti. Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti quaerat quidem magni! Modi, ipsa placeat. Commodi blanditiis odit provident, amet dolor incidunt adipisci rem, totam labore consequatur ea atque iure?</p>

                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Labore a illum temporibus neque ut sed earum eveniet voluptate ex perferendis soluta rem non laudantium eum aliquam, maxime sint, quam dolorum.</p>
            </div>
        </div>
    </main>

    <section class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fugiat fuga beatae, modi ipsum, ipsam quidem accusantium, libero pariatur quos iste tenetur sunt. Vel eum aperiam hic saepe quibusdam, vitae est.</p>
            </div>

            <div class="icono">
                <img src="build/img/icono2.svg" alt="icono precio" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fugiat fuga beatae, modi ipsum, ipsam quidem accusantium, libero pariatur quos iste tenetur sunt. Vel eum aperiam hic saepe quibusdam, vitae est.</p>
            </div>

            <div class="icono">
                <img src="build/img/icono3.svg" alt="icono tiempo" loading="lazy">
                <h3>Tiempo</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fugiat fuga beatae, modi ipsum, ipsam quidem accusantium, libero pariatur quos iste tenetur sunt. Vel eum aperiam hic saepe quibusdam, vitae est.</p>
            </div>
        </div>
    </section>

<?php 
    incluirTemplate('footer');
?>