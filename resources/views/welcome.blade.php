<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GhostNote - Notas que se autodestruyen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col items-center justify-center p-4 font-sans antialiased">

    <div class="w-full max-w-2xl bg-gray-800 rounded-xl shadow-2xl overflow-hidden border border-gray-700">
        <div class="p-8 text-center">
            <h1 class="text-4xl font-bold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">GhostNote</h1>
            <p class="text-gray-400 mb-8 text-lg">La forma más segura de enviar notas que se autodestruyen.</p>

            <div class="space-y-4">
                @if (Route::has('login'))
                    <div class="flex justify-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-purple-600 hover:bg-purple-500 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition">
                                Ir al Panel
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition border border-gray-600">
                                Iniciar Sesión
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
            
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                <div class="p-4 bg-gray-900 rounded-lg border border-gray-700">
                    <h3 class="text-purple-400 font-bold mb-2">Encriptado</h3>
                    <p class="text-sm text-gray-500">Tus secretos se encriptan antes de tocar la base de datos.</p>
                </div>
                <div class="p-4 bg-gray-900 rounded-lg border border-gray-700">
                    <h3 class="text-pink-400 font-bold mb-2">Efímero</h3>
                    <p class="text-sm text-gray-500">Se autodestruyen después de ser vistos o al expirar.</p>
                </div>
                <div class="p-4 bg-gray-900 rounded-lg border border-gray-700">
                    <h3 class="text-blue-400 font-bold mb-2">Rastreable</h3>
                    <p class="text-sm text-gray-500">Monitorea cuándo tus secretos son leídos desde tu panel.</p>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="mt-12 text-gray-600 text-sm">
        &copy; {{ date('Y') }} GhostNote. Seguro y Efímero.
    </footer>
</body>
</html>
