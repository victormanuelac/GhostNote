@extends('admin.layout')

@section('header', 'Crear Nuevo Usuario')

@section('content')
<div class="px-4 sm:px-0">
    <div class="max-w-2xl mx-auto">
        <!-- Formulario -->
        <div class="bg-gray-800 shadow rounded-lg border border-gray-700">
            <form method="POST" action="{{ route('admin.users.store') }}" class="p-6 space-y-6">
                @csrf

                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300">
                        Nombre Completo <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           required
                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">
                        Correo Electrónico <span class="text-red-400">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email') }}"
                           required
                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">
                        Contraseña <span class="text-red-400">*</span>
                    </label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           required
                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-400">Mínimo 8 caracteres</p>
                </div>

                <!-- Confirmar Contraseña -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300">
                        Confirmar Contraseña <span class="text-red-400">*</span>
                    </label>
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation" 
                           required
                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                </div>

                <!-- Rol -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-300">
                        Rol <span class="text-red-400">*</span>
                    </label>
                    <select name="role" 
                            id="role" 
                            required
                            class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm @error('role') border-red-500 @enderror">
                        <option value="">Seleccionar rol...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-400">
                        <span class="font-semibold">Admin:</span> Acceso completo al sistema. 
                        <span class="font-semibold">Usuario:</span> Acceso limitado a sus propios secretos.
                    </p>
                </div>

                <!-- Estado Activo -->
                <div class="flex items-start">
                    <div class="flex h-5 items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active" 
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="h-4 w-4 rounded border-gray-600 bg-gray-700 text-purple-600 focus:ring-purple-500">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_active" class="font-medium text-gray-300">Usuario Activo</label>
                        <p class="text-gray-400">El usuario podrá iniciar sesión y usar el sistema</p>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-700">
                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-600 text-sm font-medium rounded-md text-gray-300 bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Crear Usuario
                    </button>
                </div>
            </form>
        </div>

        <!-- Información Adicional -->
        <div class="mt-6 bg-blue-900/30 border border-blue-700 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-300">Información Importante</h3>
                    <div class="mt-2 text-sm text-blue-200">
                        <ul class="list-disc list-inside space-y-1">
                            <li>El usuario recibirá un email de bienvenida (si está configurado)</li>
                            <li>La contraseña debe tener al menos 8 caracteres</li>
                            <li>Los usuarios inactivos no podrán iniciar sesión</li>
                            <li>Puedes cambiar el rol del usuario en cualquier momento</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
