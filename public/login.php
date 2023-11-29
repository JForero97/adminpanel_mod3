<?php
require_once 'controlador/desconexion.php';
require_once 'controlador/usuarios.php';

$usuario = new Usuario($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];

    $stmt = $usuario->iniciarSesion($nombreUsuario, $contrasena);

    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['usuario_id'] = $row['usuario_id'];
        $_SESSION['tipo_usuario'] = $row['tipo_usuario'];
        
        if ($row["tipo_usuario"] == "admin") {
            header("Location: admin.php");
            exit(); 
        } elseif ($row["tipo_usuario"] == "gerente") {
            header("Location: gerente.php");
            exit(); 
        } elseif ($row["tipo_usuario"] == "cliente") {
            header("Location: cliente.php");
            exit(); 
        } else {
            header("Location: login.php");
            exit();
        }
    }
}
?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesion - Banco</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body>
        <!-- component -->
        <div class="w-full min-h-screen bg-gray-50 flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-md p-5 mx-auto">
                <h2 class="mb-12 text-center text-5xl font-extrabold">Banco</h2>
                <form method="POST">
                    <div class="mb-4">
                        <label class="block mb-1" for="usuario">Usuario</label>
                        <input id="usuario" type="text" name="usuario" class="py-2 px-3 border border-gray-300 focus:border-red-300 focus:outline-none focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm disabled:bg-gray-100 mt-1 block w-full" />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1" for="contrasena">Contraseña</label>
                        <input id="contrasena" type="password" name="contrasena" class="py-2 px-3 border border-gray-300 focus:border-red-300 focus:outline-none focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm disabled:bg-gray-100 mt-1 block w-full" />
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold capitalize text-white hover:bg-red-700 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 disabled:opacity-25 transition">Iniciar Sesion</button>
                    </div>
                </form>
            </div>
        </div>
    </body>

    </html>