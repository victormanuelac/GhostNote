<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>No Encontrado - GhostNote</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col items-center justify-center p-4 font-sans antialiased">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-purple-500 mb-4">404</h1>
        <p class="text-xl text-gray-300 mb-8">Lo sentimos, el secreto que buscas no existe o ya ha sido destruido.</p>
        <a href="{{ route('home') }}" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition">
            Volver al Inicio
        </a>
    </div>
</body>
</html>
