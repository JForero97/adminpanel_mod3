<?php
require_once 'conexion.php';
class Banco
{

    private $usuario_id;
    private $conn;

    public function __construct($usuario_id, $db)
    {
        $this->usuario_id = $usuario_id;
        $this->conn = $db;
    }

    public function cargarSaldo($cantidad)
    {
        $cantidad = floatval($cantidad);

        if ($cantidad > 0) {
            $this->actualizarBalance($cantidad);
            $this->registrarMovimiento($cantidad, 'cargar');
            return true;
        } else {
            return "Error: La cantidad debe ser mayor a 0.";
        }
    }

    public function retirarDinero($cantidad)
    {
        $cantidad = floatval($cantidad);

        if ($cantidad > 0) {
            if ($this->saldoSuficiente($cantidad)) {
                $this->actualizarBalance(-$cantidad);
                $this->registrarMovimiento($cantidad, 'retirar');
                return true;
            } else {
                return "Error: Saldo insuficiente.";
            }
        } else {
            return "Error: La cantidad debe ser mayor a 0.";
        }
    }

    public function transferir($cantidad, $destino_usuario_id)
    {
        $cantidad = floatval($cantidad);

        if ($cantidad > 0) {
            if ($this->saldoSuficiente($cantidad)) {
                $this->actualizarBalance(-$cantidad);
                $this->registrarMovimiento($cantidad, 'transferir');
                $this->registrarMovimiento($cantidad, 'transferencia_recibida', $destino_usuario_id);

                return true;
            } else {
                return "Error: Saldo insuficiente.";
            }
        } else {
            return "Error: La cantidad debe ser mayor a 0.";
        }
    }

    private function actualizarBalance($cantidad)
    {
        $query = "UPDATE usuarios SET balance = balance + :cantidad WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_STR);
        $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    private function actualizarBalanceDestino($cantidad, $destino_usuario_id)
{
    $query = "UPDATE usuarios SET balance = balance + :cantidad WHERE usuario_id = :usuario_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_STR);
    $stmt->bindParam(':usuario_id', $destino_usuario_id, PDO::PARAM_INT);
    $stmt->execute();
}

    private function saldoSuficiente($cantidad)
    {
        $query = "SELECT balance FROM usuarios WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($resultado['balance'] >= $cantidad);
    }

    private function registrarMovimiento($cantidad, $tipo_movimiento, $destino_usuario_id = null)
{
    // Registro del movimiento para el usuario de origen
    $query = "INSERT INTO movimientos (usuario_id, cantidad, tipo_movimiento) VALUES (:usuario_id, :cantidad, :tipo_movimiento)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
    $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_STR);
    $stmt->bindParam(':tipo_movimiento', $tipo_movimiento, PDO::PARAM_STR);
    $stmt->execute();

    if ($destino_usuario_id !== null) {
        // Registro del movimiento para el usuario de destino
        $query = "INSERT INTO movimientos (usuario_id, cantidad, tipo_movimiento) VALUES (:destino_usuario_id, :cantidad, 'transferencia_recibida')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':destino_usuario_id', $destino_usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_STR);
        $stmt->execute();

        // Actualizar el balance del usuario de destino
        $this->actualizarBalanceDestino($cantidad, $destino_usuario_id);
    }
}


    public function mostrarMovimientos()
    {
        $query = "SELECT * FROM movimientos WHERE usuario_id = :usuario_id ORDER BY fecha DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $movimientos;
    }

    public function obtenerSaldo()
    {
        $query = "SELECT balance FROM usuarios WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado['balance'];
    }

    public function obtenerUsuario()
    {
        $query = "SELECT nombre_usuario FROM usuarios WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado['nombre_usuario'];
    }

    function obtenerNombreUsuario($usuario_id, $tipo_usuario, $db)
    {
        if ($tipo_usuario === 'admin') {
            $query = "SELECT nombre_usuario FROM usuarios WHERE usuario_id = :usuario_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['nombre_usuario'];
        } else {
            if ($tipo_usuario === 'gerente') {
                $query = "SELECT nombre_usuario FROM usuarios WHERE usuario_id = :usuario_id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                return $resultado['nombre_usuario'];
            } else {
                if ($tipo_usuario === 'cliente') {
                    $query = "SELECT nombre_usuario FROM usuarios WHERE usuario_id = :usuario_id";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                    return $resultado['nombre_usuario'];
                }
                return '';
            }
        }
    }
}
