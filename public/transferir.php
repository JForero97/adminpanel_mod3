<?php
require_once 'controlador/banco.php';

$usuario_id = $_SESSION['usuario_id'];
$tipo_usuario = $_SESSION['tipo_usuario'];


if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$banco = new Banco($usuario_id, $db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST["accion"];

    switch ($accion) {
        case "atras":
            if ($tipo_usuario === 'admin') {
                header('Location:admin.php');
                exit();
            } elseif ($tipo_usuario === 'gerente') {
                header('Location:gerente.php');
                exit();
            } elseif ($tipo_usuario === 'cliente') {
                header('Location:cliente.php');
                exit();
            }

        case "logout":
            header('Location:login.php');
            exit();

        case "transferir":
            $cantidad = $_POST["cantidad"];
            $destino_usuario_id = $_POST["destino_usuario_id"];

            $resultado = $banco->transferir($cantidad, $destino_usuario_id);

            if ($resultado === true) {
                echo "Transferencia exitosa.";
            } else {
                echo $resultado;
            }
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

<body class='bg-gray-100'>
    <div>
        <h1 class="text-xl text-center pt-4 pb-4">Banco</h1>

        <div class='text-center'>
            <p>Bienvenido <span class="font-bold"><?php echo $banco->obtenerUsuario() ?></span>, su saldo es: <span class="font-bold text-green-700"> <?php echo $banco->obtenerSaldo(); ?> </span> </p>
        </div>

        <div class="mx-auto">
            <form method="POST">
                <div class='grid grid-cols-2 gap-3 mt-4 p-2 bg-white'>
                    <button type="submit" name="accion" value="atras">Atras</button>
                    <button type="submit" name="accion" value="logout">Cerrar Sesion</button>
            </form>
        </div>

        <div class="max-w-lg mx-auto my-4 bg-white p-8 rounded-xl shadow shadow-slate-300">
            <h1 class="text-4xl font-medium">Transfiere dinero</h1>
            <p class="text-slate-500">Escribe la cantidad de dinero</p>

            <form method="POST">
                <div class="flex flex-col space-y-5">
                    <label for="number">
                        <p class="font-medium text-slate-700 pb-2">Dinero</p>
                        <input name="cantidad" type="number" class="w-full py-3 border border-slate-200 rounded-lg px-3 focus:outline-none focus:border-slate-500 hover:shadow" placeholder="Cantidad a enviar">
                    </label>
                </div>
                <div class="flex flex-col space-y-5">
                    <label for="number">
                        <p class="font-medium text-slate-700 pb-2">ID. Destino</p>
                        <input name="destino_usuario_id" type="number" class="w-full py-3 border border-slate-200 rounded-lg px-3 focus:outline-none focus:border-slate-500 hover:shadow" placeholder="ID. Destino">
                    </label>
                </div>
                <div class='flex flex-col items-center bg-blue-200 rounded-lg p-1 mx-1 mt-2'>
                    <img src="vista/images/transfers.png" alt="Movimientos" width="50px" height="50px">
                    <button type="submit" name="accion" value="transferir">Transferir</button>
                </div>
        </div>
        </form>
    </div>
    </div>

</body>

</html>