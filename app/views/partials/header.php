<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= isset($title) ? htmlspecialchars($title) : 'ToMathEs' ?></title>
    <link rel="stylesheet" href="/assets/css/root.css" />
    <link rel="stylesheet" href="/assets/css/header.css" />
    <link rel="stylesheet" href="/assets/css/footer.css" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">

    <?php if (isset($extra_css)): ?>
        <?php foreach ($extra_css as $css_file): ?>
            <link rel="stylesheet" href="<?= htmlspecialchars($css_file) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body>
    <header class="site-header">
        <div class="header-container">

            <div class="left-group">
                <div class="main-name">
                    <h1>ToMathEs</h1>
                </div>

                <nav class="main-nav">
                    <a href="/">Inicio</a>
                    <a href="/about">Acerca</a>
                    <a href="/posts">Publicaciones</a>
                </nav>
            </div>

            <div class="right-group">
                <div class="search-bar">
                    <form action="/search" method="get">
                        <input type="text" name="query" value="<?= htmlspecialchars($query ?? '') ?>"
                            placeholder="Buscar..." required>
                        <button type="submit">
                            <span class="material-icons">search</span>
                        </button>
                    </form>
                </div>

                <?php if (isset($_SESSION['author_id'])): ?>
                    <div class="dashboard-button">
                        <a href="/admin/dashboard" class="btn-dashboard">
                            <span class="material-symbols-outlined">dashboard</span>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="login-button">
                        <a href="/login" class="btn-login">
                            <span class="material-symbols-outlined">person</span>
                        </a>
                    </div>
                <?php endif; ?>

                <button class="menu-toggle" aria-label="Menú">
                    <span class="material-icons">menu</span>
                </button>
            </div>

        </div>
    </header>

    <main>
        <script>
            const menuToggle = document.querySelector('.menu-toggle');
            const headerContainer = document.querySelector('.header-container');

            menuToggle.addEventListener('click', () => {
                headerContainer.classList.toggle('active');
                menuToggle.classList.toggle('active');
            });
        </script>