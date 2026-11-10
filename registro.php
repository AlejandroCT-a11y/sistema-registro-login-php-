<?php
// Iniciamos la sesión para conservar el arreglo de usuarios entre páginas.
session_start();

if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}

$mensaje = '';
$tipoMensaje = '';
$nombre = '';
$usuario = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibimos los datos del formulario.
    $nombre = trim($_POST['nombre'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmacion = $_POST['confirmacion'] ?? '';

    // Validaciones solicitadas.
    if ($nombre === '' || $usuario === '' || $contrasena === '' || $confirmacion === '') {
        $mensaje = 'Todos los campos son obligatorios.';
        $tipoMensaje = 'error';
    } elseif (strlen($contrasena) < 6) {
        $mensaje = 'La contraseña debe tener al menos 6 caracteres.';
        $tipoMensaje = 'error';
    } elseif ($contrasena !== $confirmacion) {
        $mensaje = 'Las contraseñas no coinciden.';
        $tipoMensaje = 'error';
    } elseif (isset($_SESSION['usuarios'][$usuario])) {
        $mensaje = 'Ese nombre de usuario ya está registrado.';
        $tipoMensaje = 'error';
    } else {
        // Guardamos ÚNICAMENTE el hash, nunca la contraseña en texto plano.
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $_SESSION['usuarios'][$usuario] = [
            'nombre' => $nombre,
            'usuario' => $usuario,
            'hash' => $hash
        ];

        $mensaje = 'Usuario registrado correctamente. Ya puedes iniciar sesión.';
        $tipoMensaje = 'exito';
        $nombre = '';
        $usuario = '';
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
    <title>Registro | Portal de empleados</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <main class="tarjeta">
        <div class="marca"><span class="marca-icono">E</span> Portal de empleados</div>
        <p class="eyebrow">ACCESO EMPRESARIAL</p>
        <h1>Crear cuenta</h1>
        <p class="descripcion">Registra tus datos para acceder al sistema.</p>

        <?php if ($mensaje !== ''): ?>
            <div class="alerta <?= escapar($tipoMensaje) ?>" role="alert">
                <?= escapar($mensaje) ?>
                <?php if ($tipoMensaje === 'exito'): ?>
                    <a href="login.php">Ir a iniciar sesión</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form action="registro.php" method="POST">
            <label for="nombre">Nombre completo</label>
            <input id="nombre" type="text" name="nombre" placeholder="Ej. Juan Pérez" value="<?= escapar($nombre) ?>" autocomplete="name" required>

            <label for="usuario">Nombre de usuario</label>
            <input id="usuario" type="text" name="usuario" placeholder="Ej. juan123" value="<?= escapar($usuario) ?>" autocomplete="username" required>

            <label for="contrasena">Contraseña</label>
            <input id="contrasena" type="password" name="contrasena" placeholder="Mínimo 6 caracteres" minlength="6" autocomplete="new-password" required>

            <label for="confirmacion">Confirmar contraseña</label>
            <input id="confirmacion" type="password" name="confirmacion" placeholder="Vuelve a escribir tu contraseña" autocomplete="new-password" required>

            <button type="submit">Registrar usuario</button>
        </form>

        <p class="pie">¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a></p>
    </main>
</body>
</html>
