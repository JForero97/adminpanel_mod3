<?php
require_once 'controlador/banco.php';

// Obtiene datos de la sesión
$usuario_id = $_SESSION['usuario_id'];
$tipo_usuario = $_SESSION['tipo_usuario'];

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'gerente') {
    header('Location: login.php');
    exit();
}

$banco = new Banco($usuario_id, $db);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST["accion"];
    $cantidad = $_POST["number"];

    switch ($accion) {
        case "cargar":
            $resultado = $banco->cargarSaldo($cantidad);
            echo ($resultado === true) ? "Saldo cargado exitosamente." : $resultado;
            break;

        case "retirar":
            $resultado = $banco->retirarDinero($cantidad);
            echo ($resultado === true) ? "Saldo retirado exitosamente." : $resultado;
            break;

        case "movimientos":
            header('Location: movimientos.php');
            exit();

        case "transferir":
            header('Location: transferir.php');
            exit();

        case "logout":
            header('Location:login.php');
            exit();

        default:
            // Acción no válida
            echo "Acción no válida.";
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class='bg-yellow-100'>
    <div>
        <h1 class="text-xl text-center pt-4 pb-4">Banco</h1>

        <div class='text-center'>
            <p>Bienvenido <span class="font-bold"><?php echo $banco->obtenerUsuario() ?></span>, su saldo es: <span class="font-bold text-green-700"> <?php echo $banco->obtenerSaldo(); ?> </span> </p>
            <form method="POST">
                <span class='mx-auto text-black-700 font-bold'>
                    <button type="sumbit" name="accion" value="logout">Cerrar Sesion</button>
                </span>
            </form>
        </div>

        <div class="max-w-lg mx-auto my-1 bg-white p-8 rounded-xl shadow shadow-slate-300">
            <h1 class="text-4xl font-medium">Gestiona tu dinero</h1>
            <p class="text-slate-500">Escribe la cantidad de dinero</p>

            <form method="POST">
                <div class="flex flex-col space-y-5">
                    <label for="number">
                        <p class="font-medium text-slate-700 pb-2">Dinero</p>
                        <input id="number" name="number" type="number" class="w-full py-3 border border-slate-200 rounded-lg px-3 focus:outline-none focus:border-slate-500 hover:shadow" placeholder="0">
                    </label>
                </div>

                <div class='grid grid-cols-3 grid-rows-2 gap-3 mt-4 p-8 bg-white'>
                    <div class='flex flex-col items-center bg-blue-200 rounded-lg p-6 mx-1'>
                        <img src="vista/images/coin.png" alt="Cargar Saldo" width="50px" height="50px">
                        <button type="submit" name="accion" value="cargar">Cargar Saldo</button>
                    </div>

                    <div class='flex flex-col items-center bg-blue-200 rounded-lg p-6 mx-1'>
                        <img src="vista/images/withdrawals.png" alt="Retirar" width="50px" height="50px">
                        <button type="submit" name="accion" value="retirar">Retirar</button>
                    </div>

                    <div class='flex flex-col items-center bg-blue-200 rounded-lg p-6 mx-1'>
                        <img src="vista/images/transaction.png" alt="Movimientos" width="50px" height="50px">
                        <button type="submit" name="accion" value="movimientos">Movimientos</button>
                    </div>

                    <div class='flex flex-col items-center bg-blue-200 rounded-lg p-6 mx-1'>
                        <img src="vista/images/transfers.png" alt="Movimientos" width="50px" height="50px">
                        <button type="submit" name="accion" value="transferir">Transferir</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

</html>