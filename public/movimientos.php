<?php
require_once 'controlador/banco.php';

$usuario_id = $_SESSION['usuario_id'];
$tipo_usuario = $_SESSION['tipo_usuario'];


if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$banco = new Banco($usuario_id, $db);
$movimientos = $banco->mostrarMovimientos();

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
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class='bg-gray-100'>

    <div>
        <h1 class="text-xl text-center pt-4 pb-4">Banco</h1>

        <div class='text-center'>
            <p>Bienvenido <span class="font-bold"><?php echo $banco->obtenerUsuario() ?></span>, su saldo es: <span class="font-bold text-green-700"> <?php echo $banco->obtenerSaldo(); ?> </span> </p>
            <p>Este es su listado de movimientos exitosos</p>
        </div>

        <div class="mx-auto">
            <form method="POST">
                <div class='grid grid-cols-2 gap-3 mt-4 p-2 bg-white'>
                    <button type="submit" name="accion" value="atras">Atras</button>
                    <button type="submit" name="accion" value="logout">Cerrar Sesion</button>
            </form>
        </div>



        <div class="max-w-2xl mx-auto mt-3">

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Id. Movimiento
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Usuario
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tipo de Movimiento
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Cantidad
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Fecha
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movimientos as $movimiento) : ?>
                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">
                                    <?php echo $movimiento['movimiento_id']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $banco->obtenerNombreUsuario($movimiento['usuario_id'], $tipo_usuario, $db); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $movimiento['tipo_movimiento']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $movimiento['cantidad']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $movimiento['fecha']; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>
        </div>
    </div>
</body>

</html>