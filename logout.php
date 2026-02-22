<?php
// Inicia la sesión actual
session_start();

// Elimina todas las variables de sesión
session_unset();

// Destruye completamente la sesión
session_destroy();

// Redirige al usuario al login
header('Location: index.php');
exit;