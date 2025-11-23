<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Create Secret Form -->
            <div class="bg-gradient-to-br from-gray-800 via-gray-800 to-gray-900 shadow-2xl sm:rounded-2xl overflow-hidden border border-gray-700/50">
                <div class="p-6 sm:p-10">
                    <section>
                        <header class="mb-8">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="p-2 bg-purple-600/20 rounded-lg">
                                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">
                                    {{ __('Crear Nuevo Secreto') }}
                                </h2>
                            </div>
                            <p class="text-gray-400 text-sm ml-14">
                                {{ __('Crea una nota segura que se autodestruirá después de ser vista.') }}
                            </p>
                        </header>

                        @if (session('created_url'))
                            <div class="relative p-6 bg-gradient-to-r from-green-900/40 to-emerald-900/40 border border-green-500/50 rounded-xl backdrop-blur-sm">
                                <div class="flex items-start gap-3 mb-4">
                                    <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-green-300 font-semibold text-lg mb-1">¡Secreto Creado Exitosamente!</p>
                                        <p class="text-green-400/80 text-sm">Tu enlace seguro está listo para compartir</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 bg-gray-900/50 rounded-lg p-3 border border-gray-700/50">
                                    <input type="text" readonly value="{{ session('created_url') }}" class="flex-1 bg-transparent border-0 text-gray-300 focus:outline-none focus:ring-0 text-sm font-mono">
                                    <button onclick="navigator.clipboard.writeText('{{ session('created_url') }}')" class="flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-lg transition-all duration-200 font-medium text-sm shadow-lg hover:shadow-green-500/50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                        Copiar
                                    </button>
                                </div>
                                <p class="text-xs text-green-400/60 mt-3 flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Este enlace se autodestruirá después de ser visto según la configuración establecida.
                                </p>
                                
                                <!-- Botón Crear Nuevo Secreto -->
                                <div class="mt-5 pt-4 border-t border-green-500/20">
                                    <a href="{{ route('dashboard') }}" class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-purple-500/50 transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Crear Nuevo Secreto
                                    </a>
                                </div>
                            </div>
                        @else
                            <form method="post" action="{{ route('secret.store') }}" class="space-y-6">
                                @csrf
                                
                                <!-- Textarea Section -->
                                <div class="space-y-2">
                                    <label for="content" class="flex items-center gap-2 text-sm font-semibold text-gray-300">
                                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Contenido del Secreto
                                    </label>
                                    <div class="relative">
                                        <textarea 
                                            id="content" 
                                            name="content" 
                                            rows="6" 
                                            class="block w-full bg-gray-900/50 border-2 border-gray-700 text-gray-200 rounded-xl shadow-inner focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-200 placeholder-gray-500 resize-none p-4 text-base" 
                                            placeholder="Escribe tu mensaje secreto aquí..."
                                            required
                                        ></textarea>
                                        <div class="absolute bottom-3 right-3 text-xs text-gray-500 pointer-events-none">
                                            <svg class="w-5 h-5 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                </div>

                                <!-- Description Field -->
                                <div class="space-y-2">
                                    <label for="description" class="flex items-center gap-2 text-sm font-semibold text-gray-300">
                                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        Descripción (Opcional)
                                    </label>
                                    <input 
                                        id="description" 
                                        name="description" 
                                        type="text" 
                                        class="block w-full bg-gray-900/50 border-2 border-gray-700 text-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-200 p-3 text-sm placeholder-gray-500" 
                                        placeholder="Ej: Contraseña de WiFi, Código de acceso, etc."
                                        maxlength="255"
                                    />
                                    <p class="text-xs text-gray-500 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Ayuda a identificar el uso de este secreto en tu panel
                                    </p>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>

                                <!-- Options Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="space-y-2">
                                        <label for="ttl" class="flex items-center gap-2 text-sm font-semibold text-gray-300">
                                            <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Tiempo de Expiración
                                        </label>
                                        <select 
                                            id="ttl" 
                                            name="ttl" 
                                            class="block w-full bg-gray-900/50 border-2 border-gray-700 text-gray-200 rounded-xl focus:border-pink-500 focus:ring-4 focus:ring-pink-500/20 transition-all duration-200 p-3 text-sm"
                                        >
                                            <option value="">∞ Nunca expira</option>
                                            <option value="5">⏱️ 5 Minutos</option>
                                            <option value="60">🕐 1 Hora</option>
                                            <option value="1440">📅 1 Día</option>
                                            <option value="10080">📆 7 Días</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label for="max_views" class="flex items-center gap-2 text-sm font-semibold text-gray-300">
                                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Vistas Máximas
                                        </label>
                                        <input 
                                            id="max_views" 
                                            name="max_views" 
                                            type="number" 
                                            class="block w-full bg-gray-900/50 border-2 border-gray-700 text-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200 p-3 text-sm" 
                                            value="1" 
                                            min="1" 
                                            required 
                                        />
                                        <x-input-error :messages="$errors->get('max_views')" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-4">
                                    <button type="submit" class="w-full group relative overflow-hidden bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-purple-500/50 transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]">
                                        <span class="relative z-10 flex items-center justify-center gap-3 text-base">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                            {{ __('Crear Secreto Seguro') }}
                                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                        </span>
                                        <div class="absolute inset-0 bg-gradient-to-r from-pink-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </button>
                                </div>
                            </form>
                        @endif
                    </section>
                </div>
            </div>

            <!-- Secrets List -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <section>
                    <header class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Mis Secretos') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Seguimiento de tus enlaces generados.') }}
                        </p>
                    </header>

                    <div class="overflow-x-auto" x-data="{
                        secrets: [],
                        init() {
                            this.fetchSecrets();
                            setInterval(() => this.fetchSecrets(), 5000);
                        },
                        fetchSecrets() {
                            fetch('{{ route('dashboard.status') }}')
                                .then(response => response.json())
                                .then(data => {
                                    this.secrets = data;
                                });
                        }
                    }">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Descripción</th>
                                    <th scope="col" class="px-6 py-3">Creado</th>
                                    <th scope="col" class="px-6 py-3">Visto</th>
                                    <th scope="col" class="px-6 py-3">Expira</th>
                                    <th scope="col" class="px-6 py-3">Estado</th>
                                    <th scope="col" class="px-6 py-3">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="secret in secrets" :key="secret.id">
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                                <span class="font-medium text-gray-900 dark:text-gray-100" x-text="secret.description"></span>
                                            </div>
                                            <div class="text-xs text-gray-500 font-mono mt-1" x-text="'ID: ' + secret.id.substring(0, 8) + '...'"></div>
                                        </td>
                                        <td class="px-6 py-4" x-text="secret.created_at_human"></td>
                                        <td class="px-6 py-4">
                                            <span :class="secret.viewed_at ? 'text-green-500' : 'text-gray-500'" x-text="secret.viewed_at_human"></span>
                                        </td>
                                        <td class="px-6 py-4" x-text="secret.expiration_human"></td>
                                        <td class="px-6 py-4">
                                            <template x-if="secret.is_burned">
                                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                                    Quemado
                                                </span>
                                            </template>
                                            <template x-if="!secret.is_burned && secret.viewed_at">
                                                <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                                    Visto
                                                </span>
                                            </template>
                                            <template x-if="!secret.is_burned && !secret.viewed_at">
                                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                    Activo
                                                </span>
                                            </template>
                                        </td>
                                        <td class="px-6 py-4">
                                            <template x-if="!secret.is_burned && !secret.viewed_at">
                                                <button @click="navigator.clipboard.writeText(secret.confirm_url); alert('Enlace copiado al portapapeles');" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">
                                                    Copiar Enlace
                                                </button>
                                            </template>
                                            <template x-if="secret.is_burned || secret.viewed_at">
                                                <span class="text-gray-400 cursor-not-allowed">No disponible</span>
                                            </template>
                                        </td>
                                    </tr>
                                </template>
                                <template x-if="secrets.length === 0">
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="6" class="px-6 py-4 text-center">
                                            No has creado secretos aún.
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
