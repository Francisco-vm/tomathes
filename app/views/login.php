<?php
$title = "Login | ToMathEs";
$extra_css = ["/assets/css/login.css"];
require __DIR__ . '/partials/header.php';

if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>

<div class="login-container">
    <h2>Iniciar sesión</h2>

    <?php if (!empty($error)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="/login" method="post">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Ingresar</button>
    </form>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>