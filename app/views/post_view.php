<?php
$title = "Publicación | ToMathEs";
require __DIR__ . '/partials/header.php';
?>

<h1><?= htmlspecialchars($post['title']) ?></h1>
<p><?= htmlspecialchars($post['content']) ?></p>
<p><small>Publicado el <?= htmlspecialchars($post['created_at']) ?></small></p>

<hr>

<h2>Comentarios</h2>
<div id="comments-container">
    <!-- Formulario para agregar un nuevo comentario al post -->
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

    <hr>

    <!-- Mostrar comentarios existentes -->
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <div style="margin-left: <?= $comment['parent_id'] ? '40px' : '0' ?>;">
                <p><strong><?= htmlspecialchars($comment['name']) ?></strong></p>
                <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>

                <!-- Botón de responder que muestra el formulario de respuesta (JS) -->
                <button onclick="toggleReplyForm(<?= $comment['id'] ?>)">Responder</button>

                <!-- Formulario oculto para responder -->
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

            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay comentarios aún.</p>
    <?php endif; ?>
</div>

<script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById('reply-form-' + commentId);
        form.style.display = (form.style.display === 'none') ? 'block' : 'none';
    }
</script>

<script>
    document.querySelectorAll('.ajax-comment-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Evitar recarga normal

            const formData = new FormData(this);

            fetch('/comments/create', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.reset();

                        const parentId = form.querySelector('input[name="parent_id"]').value;
                        const postId = form.querySelector('input[name="post_id"]').value;

                        const newComment = document.createElement('div');
                        newComment.style.marginLeft = parentId ? '40px' : '0';

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

                        // Re-activar AJAX para el formulario recién agregado
                        const newForm = newComment.querySelector('.ajax-comment-form');
                        newForm.addEventListener('submit', function (e) {
                            e.preventDefault();
                            const newFormData = new FormData(this);

                            fetch('/comments/create', {
                                method: 'POST',
                                body: newFormData
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        this.reset();
                                        this.style.display = 'none';

                                        // Crear el nuevo div para la respuesta
                                        const replyDiv = document.createElement('div');
                                        replyDiv.style.marginLeft = '40px';  // porque es respuesta
                                        replyDiv.innerHTML = `
                <p><strong>${data.comment.name}</strong></p>
                <p>${data.comment.content.replace(/\n/g, '<br>')}</p>
                <button onclick="toggleReplyForm(${data.comment.id})">Responder</button>

                <form class="ajax-comment-form" id="reply-form-${data.comment.id}" action="/comments/create" method="POST" style="display:none;">
                    <input type="hidden" name="post_id" value="${newFormData.get('post_id')}">
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

                                        // Insertar la respuesta debajo del formulario que la envió
                                        this.parentNode.insertBefore(replyDiv, this.nextSibling);

                                        // Volver a activar evento submit para el nuevo formulario de respuesta dentro de replyDiv
                                        const nestedForm = replyDiv.querySelector('.ajax-comment-form');
                                        nestedForm.addEventListener('submit', arguments.callee);  // reusar esta misma función

                                    } else {
                                        alert("Error al publicar la respuesta.");
                                    }
                                })
                                .catch(err => {
                                    console.error(err);
                                    alert("Ocurrió un error al enviar la respuesta.");
                                });
                        });


                    } else {
                        alert("Error al publicar el comentario.");
                    }
                })

                .catch(err => {
                    console.error(err);
                    alert("Ocurrió un error al enviar el comentario.");
                });
        });
    });
</script>