<?php
$title = "Admin Dashboard | ToMathEs";
$extra_css = ["/assets/css/admin.css"];
require __DIR__ . '/../partials/header.php';
?>

<div class="admin-dashboard-container">
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['author_name']); ?>.</h2>

    <div class="dashboard-actions">
        <a href="/posts/create" class="dashboard-btn">Crear nuevo post</a>
        <a href="/logout" class="dashboard-btn logout-btn">Cerrar sesión</a>
    </div>

    <h3>Tus publicaciones</h3>
    <div class="posts-grid">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-card">
                    <h4><?php echo htmlspecialchars($post['title']); ?></h4>
                    <p>Publicado: <?php echo date('d/m/Y', strtotime($post['created_at'])); ?></p>
                    <a href="/posts/edit/<?php echo $post['id']; ?>" class="edit-btn">Editar</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No tienes publicaciones aún.</p>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>