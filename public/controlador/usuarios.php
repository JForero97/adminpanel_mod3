<?php
require_once 'conexion.php';

class Usuario
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function iniciarSesion($nombreUsuario, $contrasena)
    {
        $query = "SELECT * FROM usuarios WHERE nombre_usuario = :nombreUsuario AND contrasena = :contrasena";
        $stmt = $this->conn->prepare($query);

        $nombreUsuario = htmlspecialchars(strip_tags($nombreUsuario));
        $contrasena = htmlspecialchars(strip_tags($contrasena));

        $stmt->bindParam(':nombreUsuario', $nombreUsuario);
        $stmt->bindParam(':contrasena', $contrasena);

        $stmt->execute();

        return $stmt;
    }

    public function obtenerUsuarioPorID($usuarioID)
    {
        $query = "SELECT * FROM usuarios WHERE usuario_id = :usuarioID";
        $stmt = $this->conn->prepare($query);

        $usuarioID = htmlspecialchars(strip_tags($usuarioID));

        $stmt->bindParam(':usuarioID', $usuarioID);

        $stmt->execute();

        return $stmt;
    }
}
?>