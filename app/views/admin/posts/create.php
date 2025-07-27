<?php
$title = "Crear nuevo post | ToMathEs";
$extra_css = ["/assets/css/create.css"];
require __DIR__ . '/../../partials/header.php';
?>

<div class="create-post-container">
    <h2>Crear nuevo post</h2>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="error"><?php echo $_SESSION['error'];
        unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="/posts/create" method="POST" id="postForm">

        <select id="category_id" name="category_id" required>
            <option value="">Selecciona una categoría</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['id']); ?>">
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div>
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div>
            <label for="content">Contenido:</label>

            <div id="editor" style="height: 350px; background: white;"></div>

            <input type="hidden" name="content" id="content">
        </div>

        <button type="submit">Guardar</button>
    </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<script>
    var toolbarOptions = [
        [{ 'font': [] }],
        [{ 'size': ['small', false, 'large', 'huge'] }],  // Tamaños

        ['bold', 'italic', 'underline', 'strike'],        // Negrita, cursiva, subrayado, tachado
        [{ 'script': 'sub' }, { 'script': 'super' }],      // Subíndice, superíndice
        [{ 'color': [] }, { 'background': [] }],          // Color texto y fondo

        [{ 'header': 1 }, { 'header': 2 }, { 'header': 3 }, 'blockquote', 'code-block'],

        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
        [{ 'indent': '-1' }, { 'indent': '+1' }],           // Sangría
        [{ 'direction': 'rtl' }],                          // Dirección texto (derecha a izquierda)

        [{ 'align': [] }],                                 // Alineación

        ['link', 'image'],                        // Enlaces, imágenes y videos

        ['clean']                                          // Limpiar formato
    ];

    var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Escribe el contenido aquí...',
        modules: {
            toolbar: toolbarOptions
        }
    });

    // Copiar contenido HTML al input oculto al enviar el formulario
    document.getElementById('postForm').addEventListener('submit', function (e) {
        var content = document.querySelector('input[name=content]');
        content.value = quill.root.innerHTML;

        // Validar contenido no vacío (solo texto)
        if (quill.getText().trim().length === 0) {
            e.preventDefault();
            alert('El contenido no puede estar vacío.');
        }
    });
</script>

<?php require __DIR__ . '/../../partials/footer.php'; ?>