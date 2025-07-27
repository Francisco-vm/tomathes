<?php
$title = "Publicación | ToMathEs";
$extra_css = ["/assets/css/post_view.css"];
require __DIR__ . '/partials/header.php';
?>

<article class="post-container">
    <header>
        <h1><?= htmlspecialchars($post['title']) ?></h1>
        <p><small>Publicado el <?= htmlspecialchars($post['created_at']) ?></small></p>
    </header>

    <section class="post-content">
        <p><?= $post['content_html'] ?></p>
    </section>
</article>

<section id="comments-container">
    <h2>Comentarios</h2>

    <!-- Formulario para agregar un nuevo comentario -->
    <form id="comment-form" class="ajax-comment-form" action="/comments/create" method="POST">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <input type="hidden" name="parent_id" value="">

        <div>
            <label for="name">Nombre:</label>
            <input type="text" name="name" required>
        </div>

        <div>
            <label for="content">Comentario:</label>
            <textarea name="content" required></textarea>
        </div>

        <button type="submit">Publicar comentario</button>
    </form>

    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <article class="comment <?= $comment['parent_id'] ? 'reply' : '' ?>">
                <header>
                    <p><strong><?= htmlspecialchars($comment['name']) ?></strong></p>
                </header>
                <section class="comment-content">
                    <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                </section>

                <button onclick="toggleReplyForm(<?= $comment['id'] ?>)">Responder</button>

                <form class="ajax-comment-form" id="reply-form-<?= $comment['id'] ?>" action="/comments/create" method="POST"
                    style="display:none;">
                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                    <input type="hidden" name="parent_id" value="<?= $comment['id'] ?>">

                    <div>
                        <label for="name">Nombre:</label>
                        <input type="text" name="name" required>
                    </div>

                    <div>
                        <label for="content">Respuesta:</label>
                        <textarea name="content" required></textarea>
                    </div>

                    <button type="submit">Publicar respuesta</button>
                </form>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay comentarios aún.</p>
    <?php endif; ?>
</section>
<script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById('reply-form-' + commentId);
        form.style.display = (form.style.display === 'none') ? 'block' : 'none';
    }

    function handleCommentFormSubmit(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        fetch('/comments/create', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    form.reset();

                    const parentId = form.querySelector('input[name="parent_id"]').value;
                    const postId = form.querySelector('input[name="post_id"]').value;

                    const newComment = document.createElement('article');
                    newComment.classList.add('comment');
                    if (parentId) newComment.classList.add('reply');

                    newComment.innerHTML = `
                <p><strong>${data.comment.name}</strong></p>
                <p>${data.comment.content.replace(/\n/g, '<br>')}</p>
                <button onclick="toggleReplyForm(${data.comment.id})">Responder</button>

                <form class="ajax-comment-form" id="reply-form-${data.comment.id}" action="/comments/create" method="POST" style="display:none;">
                    <input type="hidden" name="post_id" value="${postId}">
                    <input type="hidden" name="parent_id" value="${data.comment.id}">

                    <div>
                        <label for="name">Nombre:</label>
                        <input type="text" name="name" required>
                    </div>

                    <div>
                        <label for="content">Respuesta:</label>
                        <textarea name="content" required></textarea>
                    </div>

                    <button type="submit">Publicar respuesta</button>
                </form>
            `;

                    if (form.id.startsWith('reply-form-')) {
                        form.parentNode.insertBefore(newComment, form.nextSibling);
                        form.style.display = 'none';
                    } else {
                        document.getElementById('comments-container').appendChild(newComment);
                    }

                    // Re-activar AJAX para el nuevo formulario
                    const newForm = newComment.querySelector('.ajax-comment-form');
                    newForm.addEventListener('submit', handleCommentFormSubmit);

                } else {
                    alert("Error al publicar el comentario.");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Ocurrió un error al enviar el comentario.");
            });
    }

    document.querySelectorAll('.ajax-comment-form').forEach(form => {
        form.addEventListener('submit', handleCommentFormSubmit);
    });
</script>