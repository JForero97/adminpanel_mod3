<?php
$db = null; // Cierra la conexión con la base de datos
if (session_status() === PHP_SESSION_ACTIVE) {
    unset($_SESSION['usuario_id']);
    unset($_SESSION['tipo_usuario']);
    session_destroy();
    session_regenerate_id(true);
}
?>