<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GhostNote - Secreto Revelado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col items-center justify-center p-4 font-sans antialiased">

    <div class="w-full max-w-2xl bg-gray-800 rounded-xl shadow-2xl overflow-hidden border border-gray-700">
        <div class="p-8">
            <h1 class="text-2xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">Secreto Revelado</h1>
            
            <div class="bg-gray-900 rounded-lg p-6 border border-gray-700 mb-6 font-mono text-gray-300 whitespace-pre-wrap break-words">
{{ $content }}
            </div>

            <div class="bg-yellow-900/20 border border-yellow-700/50 rounded p-4 mb-8">
                <p class="text-yellow-500 text-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Esta nota ha sido vista y ahora está destruida (o el contador de vistas ha aumentado).
                </p>
            </div>

            <div class="text-center">
                <a href="{{ route('dashboard') }}" class="inline-block bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-8 rounded-lg transition">
                    Volver al Panel
                </a>
            </div>
        </div>
    </div>

</body>
</html>
