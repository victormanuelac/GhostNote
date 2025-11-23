<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GhostNote - Confirmar Vista</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col items-center justify-center p-4 font-sans antialiased">

    <div class="w-full max-w-md" x-data="{ 
        showModal: false, 
        secretContent: '', 
        loading: false,
        error: null,
        reveal() {
            this.loading = true;
            this.error = null;
            fetch('{{ route('secret.show', ['id' => $id]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Secret not found or expired');
                return response.json();
            })
            .then(data => {
                this.secretContent = data.content;
                this.showModal = true;
            })
            .catch(err => {
                this.error = 'El secreto ya no existe o ha expirado.';
            })
            .finally(() => {
                this.loading = false;
            });
        }
    }">
        <!-- Confirm Card -->
        <div class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden border border-red-900/50">
            <div class="p-8 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-900/30 mb-6">
                    <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold mb-4 text-white">
                    @if($isAvailable)
                        ¡Ten cuidado!
                    @else
                        No disponible
                    @endif
                </h2>
                <p class="text-gray-400 mb-8">
                    @if($isAvailable)
                        Estás a punto de ver una nota segura. 
                        <br><br>
                        <span class="text-red-400 font-semibold">Este mensaje se autodestruirá inmediatamente después de verlo.</span>
                    @else
                        Este secreto ya no existe, ha expirado o ya ha sido visto.
                    @endif
                </p>

                <div x-show="error" class="mb-4 p-3 bg-red-900/50 border border-red-500 rounded text-red-200 text-sm" x-text="error"></div>

                @if($isAvailable)
                    <button @click="reveal" :disabled="loading" class="w-full bg-red-600 hover:bg-red-500 text-white font-bold py-3 rounded-lg shadow-lg transition disabled:opacity-50">
                        <span x-show="!loading">Sí, muéstrame el secreto</span>
                        <span x-show="loading">Revelando...</span>
                    </button>
                    
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-400 text-sm">Cancelar</a>
                    </div>
                @else
                    <div class="mt-4">
                        <a href="{{ route('secret.burned') }}" class="inline-block w-full bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 rounded-lg shadow-lg transition">
                            Cerrar
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal -->
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-700">
                    <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                    Secreto Revelado
                                </h3>
                                <div class="mt-4">
                                    <div class="bg-gray-900 rounded p-4 border border-gray-700 font-mono text-gray-300 whitespace-pre-wrap break-words text-sm" x-text="secretContent"></div>
                                </div>
                                <div class="mt-4 bg-yellow-900/20 border border-yellow-700/50 rounded p-3">
                                    <p class="text-yellow-500 text-xs">
                                        Esta nota ha sido vista y ahora está destruida (o el contador de vistas ha aumentado).
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-700">
                        <a href="{{ route('secret.burned') }}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Cerrar
                        </a>
                        <button type="button" @click="navigator.clipboard.writeText(secretContent); alert('Copiado al portapapeles')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Copiar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
