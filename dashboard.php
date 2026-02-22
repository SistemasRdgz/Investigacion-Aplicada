<?php
// Inicia la sesión
session_start();

// Verifica si el usuario NO está autenticado
// Si no hay sesión activa, lo redirige al login
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="dashboard-page">

    <header class="site-header">
        <div class="container">

            <!-- Título principal -->
            <h2 class="brand">Lenguaje Interpretado En El Servidor</h2>

            <nav class="nav-right">

                <!-- Muestra el usuario autenticado de forma segura -->
                <span class="user">
                    <?php echo htmlspecialchars($_SESSION['user']); ?>
                </span>

                <!-- Enlace para cerrar sesión -->
                <a class="btn-ghost" href="logout.php">Cerrar sesión</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="dashboard">
            <h1>Dashboard</h1>

            <!-- Mensaje de confirmación de sesión -->
            <p class="lead">
                Has iniciado sesión como 
                <strong><?php echo htmlspecialchars($_SESSION['user']); ?></strong>.
            </p>

            <!-- Opciones simuladas del dashboard -->
            <div class="cards">
                <div class="card-sm card-blue">
                    <h3>Opción 1</h3>
                    <p>Accede a tus estadísticas y reportes.</p>
                </div>

                <div class="card-sm card-green">
                    <h3>Opción 2</h3>
                    <p>Gestiona tus tareas y proyectos.</p>
                </div>

                <div class="card-sm card-purple">
                    <h3>Opción 3</h3>
                    <p>Configura tus preferencias.</p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>