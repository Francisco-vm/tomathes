<?php
$title = "Editar post | ToMathEs";
$extra_css = [
    "/assets/css/create.css",
    "/assets/css/edit.css"
];

require __DIR__ . '/../../partials/header.php';
?>

<div class="create-post-container">
    <h2>Editar post</h2>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="error"><?php echo $_SESSION['error'];
        unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="/posts/edit/<?php echo (isset($post) && is_object($post) && isset($post->id)) ? $post->id : ''; ?>" method="POST" id="postForm">

        <select id="category_id" name="category_id" required>
            <option value="">Selecciona una categoría</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php if (isset($post) && is_object($post) && isset($post->category_id) && $category['id'] == $post->category_id)
                       echo 'selected'; ?>>
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>


        <div>
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post->title); ?>" required>
        </div>

        <div>
            <label for="content">Contenido:</label>

            <div id="editor" style="height: 350px; background: white;"></div>

            <input type="hidden" name="content" id="content">
        </div>

        <div class="buttons-container">
            <button type="submit" name="action" value="draft">Guardar como borrador</button>
            <button type="submit" name="action" value="publish">Publicar</button>
            <button type="submit" name="action" value="delete"
                onclick="return confirm('¿Estás seguro de eliminar este post? Esta acción no se puede deshacer.');">Eliminar</button>
        </div>
    </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<script>
    var toolbarOptions = [
        [{ 'font': [] }],
        [{ 'size': ['small', false, 'large', 'huge'] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'script': 'sub' }, { 'script': 'super' }],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'header': 1 }, { 'header': 2 }, { 'header': 3 }, 'blockquote', 'code-block'],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
        [{ 'indent': '-1' }, { 'indent': '+1' }],
        [{ 'direction': 'rtl' }],
        [{ 'align': [] }],
        ['link', 'image'],
        ['clean']
    ];

    var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Edita el contenido aquí...',
        modules: {
            toolbar: toolbarOptions
        }
    });

    // Establecer el contenido existente
    quill.root.innerHTML = <?php echo json_encode($post->content); ?>;

    // Copiar contenido HTML al input oculto al enviar el formulario
    document.getElementById('postForm').addEventListener('submit', function (e) {
        var content = document.querySelector('input[name=content]');
        content.value = quill.root.innerHTML;

        if (quill.getText().trim().length === 0) {
            e.preventDefault();
            alert('El contenido no puede estar vacío.');
        }
    });
</script>

<?php require __DIR__ . '/../../partials/footer.php'; ?>