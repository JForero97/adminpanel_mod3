@extends('adminlte::page')

@section('title', 'Bancojones')

@section('content_header')
    <h1>Mi Banco</h1>
@stop

@section('content')

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
                        <img src="../public/vista/coin.png" alt="Cargar Saldo" width="50px" height="50px">
                        <button type="submit" name="accion" value="cargar">Cargar Saldo</button>
                    </div>

                    <div class='flex flex-col items-center bg-blue-200 rounded-lg p-6 mx-1'>
                        <img src="vista/images/withdrawals.png" alt="Retirar" width="50px" height="50px">
                        <button type="submit" name="accion" value="retirar">Retirar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop