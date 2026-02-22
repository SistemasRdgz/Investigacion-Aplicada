<?php
// Inicia o reanuda la sesión 
// Es lo que permite que un sistema “sepa” que tú ya iniciaste sesión.
session_start();

// Si el usuario ya inició sesión, lo redirige al dashboard
// $_ Session Es como una “cajita” donde guardas datos que quieres que el servidor recuerde
// Si el usuario ya tiene una sesión iniciada, mándalo
// directamente al dashboard y no le muestres el login otra vez.”
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit; // Detiene la ejecución del script
}

// Verifica si existe un mensaje de error enviado por URL
// “¿Viene algo llamado error en la URL?”
// htmlspecialchars evita inyección de código (XSS)
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page">
    <main class="page-center">
        <section class="card">
            <div class="card-header">
                <h1>Iniciar sesión</h1>
            </div>

            <div class="card-body">

                <!-- Si existe error, se muestra en pantalla -->
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>

                <!-- Formulario que envía datos por método POST -->
                <form method="post" action="authenticate.php" class="form">

                    <!-- Campo usuario , autofocus se activa aut. al recargar-->
                    <label class="form-label">Usuario</label>
                    <input class="input" type="text" name="username" required >

                    <!-- Campo contraseña -->
                    <label class="form-label">Contraseña</label>
                    <input class="input" type="password" name="password" required>

                    <!-- Botón enviar -->
                    <button class="btn" type="submit">Entrar</button>
                </form>

            </div>
        </section>
    </main>     
</body>
</html>