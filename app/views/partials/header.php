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
    <header>
        <div class="header-container">
            <div class="main-name">
                <h1>ToMathEs</h1>
            </div>
            <nav class="main-nav">
                <a href="/">Inicio</a> |
                <a href="/about">Acerca</a> |
                <a href="/posts">Publicaciones</a>
            </nav>
            <div class="search-bar">

            </div>
        </div>
    </header>

    <main>