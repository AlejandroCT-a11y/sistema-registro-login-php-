# Registro e inicio de sesión en PHP

Proyecto escolar en PHP **sin base de datos**. Los usuarios se almacenan en un arreglo de `$_SESSION` para que el registro y el inicio de sesión funcionen entre páginas del mismo navegador.

## Archivos

- `registro.php`: formulario de registro y validaciones; guarda el hash con `password_hash()`.
- `login.php`: busca al usuario y valida con `password_verify()`.
- `estilos.css`: apariencia visual de ambas páginas.

## Cómo ejecutar en XAMPP

1. Descomprime la carpeta `sistema_usuarios_php`.
2. Copia la carpeta a `htdocs` de XAMPP (en macOS normalmente `/Applications/XAMPP/xamppfiles/htdocs/`; en Windows normalmente `C:\xampp\htdocs\`).
3. Enciende **Apache** en XAMPP. No es necesario iniciar MySQL.
4. En **el mismo navegador**, abre `http://localhost/sistema_usuarios_php/registro.php`.
5. Completa los cuatro campos y pulsa **Registrar usuario**.
6. Entra en `http://localhost/sistema_usuarios_php/login.php` e inicia sesión con el usuario y la contraseña recién creados.

## Pruebas sugeridas

- Dejar campos vacíos: el formulario no permitirá enviarlo (además el servidor lo valida).
- Contraseña de menos de 6 caracteres: aparecerá un error.
- Confirmación diferente: aparecerá un error.
- Mismo usuario otra vez: aparecerá un error.
- Login correcto: aparecerá **Acceso autorizado**.
- Login incorrecto: aparecerá **Acceso rechazado**.

## Limitación de la práctica

Los usuarios están en `$_SESSION`, no en una base de datos ni en un almacenamiento permanente. Se conservan entre `registro.php` y `login.php` **mientras la misma sesión del navegador siga activa**. Pueden perderse al terminar/expirar la sesión, y no se comparten entre navegadores u otros empleados. Esto sirve para la demostración escolar pedida, pero no para un sistema real de producción.

La contraseña original **no** se guarda en el arreglo: sólo se guarda el hash (`PASSWORD_DEFAULT`).
