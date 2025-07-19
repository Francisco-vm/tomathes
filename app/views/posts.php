<?php
$title = "Publicaciones | ToMathEs";
$extra_css = ["/assets/css/posts.css"];
require __DIR__ . '/partials/header.php';
?>

<div class="content-container">
    <aside class="categories-filter">
        <nav aria-label="Filtrar por categoría">
            <h2>Categorías</h2>
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
    </aside>

    <section class="posts-list">
        <h1>Publicaciones recientes</h1>

        <?php if (empty($posts)): ?>
            <p>No hay publicaciones disponibles.</p>
        <?php else: ?>
            <div class="posts-grid">
                <?php foreach ($posts as $post): ?>
                    <article class="post-card">
                        <header>
                            <h2 class="post-title">
                                <a href="/post/<?= urlencode($post['slug']) ?>">
                                    <?= htmlspecialchars($post['title']) ?>
                                </a>
                            </h2>
                        </header>
                        <div class="post-meta">
                            <time datetime="<?= htmlspecialchars($post['created_at']) ?>">
                                <?= date('d M Y', strtotime($post['created_at'])) ?>
                            </time>
                            <span class="post-category">
                                <?= htmlspecialchars($post['category_name']) ?>
                            </span>

                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>