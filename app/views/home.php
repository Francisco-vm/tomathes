<?php
$title = "Inicio | ToMathEs";
$extra_css = ["/assets/css/home.css"];
require __DIR__ . '/partials/header.php';
?>

<section class="welcome-section">
    <h2>Bienvenido a ToMathEs</h2>
    <p>Tu comunidad de aprendizaje matemático y científico.</p>
    <p>Aquí encontrarás publicaciones, debates y mucho más.</p>
</section>

<section class="what-is-math">
    <h2>¿Qué son las Matemáticas?</h2>
    <p>Las matemáticas son mucho más que números y ecuaciones. Son el lenguaje que nos permite describir y entender el
        universo, desde las formas más simples hasta los patrones más complejos.</p>

    <div class="cards-container">
        <article class="card">
            <div class="card-icon">
                <span class="material-symbols-outlined">
                    neurology
                </span>
            </div>
            <div class="card-body">
                <h3>Pensamiento Lógico</h3>
                <p>Las matemáticas desarrollan el razonamiento lógico y la capacidad de resolver problemas complejos de
                    manera estructurada.</p>
            </div>
        </article>

        <article class="card">
            <div class="card-icon">
                <span class="material-symbols-outlined">
                    glyphs
                </span>
            </div>
            <div class="card-body">
                <h3>Lenguaje Universal</h3>
                <p>A diferencia de los idiomas humanos, las matemáticas son un lenguaje universal que trasciende
                    fronteras culturales y lingüísticas.</p>
            </div>
        </article>

        <article class="card">
            <div class="card-icon">
                <span class="material-symbols-outlined">
                    construction
                </span>
            </div>
            <div class="card-body">
                <h3>Aplicación Práctica</h3>
                <p>Desde la ingeniería hasta la economía, las matemáticas son la base de innumerables aplicaciones
                    prácticas en el mundo real.</p>
            </div>
        </article>

    </div>
</section>

<section class="math-areas">
    <h2>Áreas de las Matemáticas</h2>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>