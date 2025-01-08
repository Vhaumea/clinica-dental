<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso denegado</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="bg-fondo flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg text-center">
        <h1 class="text-4xl font-bold text-red-500 mb-4">403</h1>
        <h2 class="text-2xl font-semibold mb-4">Acceso denegado</h2>
        <p class="text-gray-700 mb-4">No tienes permiso para acceder a esta página.</p>
        <a href="{{ url('/') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Volver al inicio</a>
    </div>
</body>
</html>