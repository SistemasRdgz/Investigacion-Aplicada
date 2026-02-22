<?php
// Inicia la sesión para poder guardar datos del usuario
session_start();

// Credenciales simuladas (no se usa base de datos)
$validUser = 'LIS';
$validPass = '$nvestigacionUDB';

// Verifica que la solicitud sea tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtiene y limpia los datos enviados por el formulario
    $user = isset($_POST['username']) ? trim($_POST['username']) : '';
    $pass = isset($_POST['password']) ? $_POST['password'] : '';

    // Compara las credenciales ingresadas con las válidas
    if ($user === $validUser && $pass === $validPass) {

        // Guarda el usuario en la sesión
        $_SESSION['user'] = $user;

        // Redirige al dashboard
        header('Location: dashboard.php');
        exit;

    } else {

        // Si las credenciales son incorrectas, envía mensaje de error
        $msg = urlencode('Credenciales inválidas');
        header("Location: index.php?error=$msg");
        exit;
    }
}
