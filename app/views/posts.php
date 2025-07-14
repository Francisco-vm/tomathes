<?php
$title = "Publicaciones | ToMathEs";
$extra_css = ["/assets/css/home.css"];
require __DIR__ . '/partials/header.php';
?>

<h2>Publicaciones recientes</h2>

<nav>
    <ul>
        <li><a href="/posts">Todas</a></li>
        <?php foreach ($categories as $category): ?>
            <li>
                <a href="/posts/<?= urlencode($category['slug']) ?>">
                    <?= htmlspecialchars($category['name']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>


<?php if (empty($posts)): ?>
    <p>No hay publicaciones disponibles.</p>
<?php else: ?>
    <ul>
        <?php foreach ($posts as $post): ?>
            <h2>
                <a href="/post/<?= urlencode($post['slug']) ?>">
                    <?= htmlspecialchars($post['title']) ?>
                </a>
            </h2>
        <?php endforeach; ?>

    </ul>
<?php endif; ?>

<?php require __DIR__ . '/partials/footer.php'; ?>