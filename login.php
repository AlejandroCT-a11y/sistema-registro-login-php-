<?php
// Leemos el mismo arreglo de usuarios desde la sesión.
session_start();

if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}

$mensaje = '';
$tipoMensaje = '';
$usuario = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenemos el usuario y la contraseña capturada.
    $usuario = trim($_POST['usuario'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if ($usuario === '' || $contrasena === '') {
        $mensaje = 'Completa el usuario y la contraseña.';
        $tipoMensaje = 'error';
    } elseif (isset($_SESSION['usuarios'][$usuario])) {
        // Recuperamos el hash que se creó en registro.php.
        $hash = $_SESSION['usuarios'][$usuario]['hash'];

        // Comparamos la contraseña ingresada con el hash almacenado.
        if (password_verify($contrasena, $hash)) {
            session_regenerate_id(true);
            $_SESSION['autenticado'] = $usuario;
            $nombre = $_SESSION['usuarios'][$usuario]['nombre'];
            $mensaje = 'Acceso autorizado. ¡Bienvenido al sistema, ' . $nombre . '!';
            $tipoMensaje = 'exito';
        } else {
            $mensaje = 'Acceso rechazado. Usuario o contraseña incorrectos.';
            $tipoMensaje = 'error';
        }
    } else {
        $mensaje = 'Acceso rechazado. Usuario o contraseña incorrectos.';
        $tipoMensaje = 'error';
    }
}

function escapar(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión | Portal de empleados</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <main class="tarjeta">
        <div class="marca"><span class="marca-icono">E</span> Portal de empleados</div>
        <p class="eyebrow">ACCESO EMPRESARIAL</p>
        <h1>Bienvenido de nuevo</h1>
        <p class="descripcion">Ingresa tus datos para acceder.</p>

        <?php if ($mensaje !== ''): ?>
            <div class="alerta <?= escapar($tipoMensaje) ?>" role="alert"><?= escapar($mensaje) ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <label for="usuario">Nombre de usuario</label>
            <input id="usuario" type="text" name="usuario" placeholder="Tu usuario" value="<?= escapar($usuario) ?>" autocomplete="username" required>

            <label for="contrasena">Contraseña</label>
            <input id="contrasena" type="password" name="contrasena" placeholder="Tu contraseña" autocomplete="current-password" required>

            <button type="submit">Iniciar sesión</button>
        </form>

        <p class="pie">¿No tienes cuenta? <a href="registro.php">Crear una cuenta</a></p>
    </main>
</body>
</html>
