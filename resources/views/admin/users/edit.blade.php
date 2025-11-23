@extends('admin.layout')

@section('header', 'Editar Usuario')

@section('content')
<div class="px-4 sm:px-0">
    <div class="max-w-2xl mx-auto">
        <!-- Información del Usuario -->
        <div class="mb-6 bg-gray-800 border border-gray-700 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12">
                    <div class="h-12 w-12 rounded-full bg-purple-600 flex items-center justify-center">
                        <span class="text-white font-semibold text-lg">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-white">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-400">{{ $user->email }}</p>
                </div>
                <div class="ml-auto">
                    @if($user->is_active)
                        <span class="inline-flex items-center rounded-full bg-green-900/50 px-3 py-1 text-sm font-medium text-green-300 ring-1 ring-inset ring-green-700">
                            Activo
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-red-900/50 px-3 py-1 text-sm font-medium text-red-300 ring-1 ring-inset ring-red-700">
                            Inactivo
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-gray-800 shadow rounded-lg border border-gray-700">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300">
                        Nombre Completo <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $user->name) }}"
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
                           value="{{ old('email', $user->email) }}"
                           required
                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cambiar Contraseña (Opcional) -->
                <div class="border-t border-gray-700 pt-6">
                    <h4 class="text-sm font-medium text-gray-300 mb-4">Cambiar Contraseña (Opcional)</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-300">
                                Nueva Contraseña
                            </label>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm @error('password') border-red-500 @enderror">
                            @error('password')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-400">Dejar en blanco para mantener la contraseña actual</p>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-300">
                                Confirmar Nueva Contraseña
                            </label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation" 
                                   class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                        </div>
                    </div>
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
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" 
                                    {{ (old('role', $user->roles->first()->name ?? '') === $role->name) ? 'selected' : '' }}>
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    @if($user->isAdmin() && $user->id === auth()->id())
                        <p class="mt-1 text-xs text-yellow-400">
                            ⚠️ Ten cuidado al cambiar tu propio rol de administrador
                        </p>
                    @endif
                </div>

                <!-- Estado Activo -->
                <div class="flex items-start">
                    <div class="flex h-5 items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active" 
                               {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                               {{ $user->id === auth()->id() ? 'disabled' : '' }}
                               class="h-4 w-4 rounded border-gray-600 bg-gray-700 text-purple-600 focus:ring-purple-500">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_active" class="font-medium text-gray-300">Usuario Activo</label>
                        <p class="text-gray-400">El usuario podrá iniciar sesión y usar el sistema</p>
                        @if($user->id === auth()->id())
                            <p class="text-yellow-400 text-xs mt-1">No puedes desactivar tu propia cuenta</p>
                        @endif
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="bg-gray-900/50 rounded-lg p-4 border border-gray-700">
                    <h4 class="text-sm font-medium text-gray-300 mb-2">Información del Usuario</h4>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs text-gray-400">Fecha de Registro</dt>
                            <dd class="text-sm text-gray-200">{{ $user->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-400">Último Login</dt>
                            <dd class="text-sm text-gray-200">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-400">Total de Secretos</dt>
                            <dd class="text-sm text-gray-200">{{ $user->secrets->count() }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-400">Email Verificado</dt>
                            <dd class="text-sm text-gray-200">{{ $user->email_verified_at ? 'Sí' : 'No' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-700">
                    <div>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-600 text-sm font-medium rounded-md text-red-400 bg-red-900/20 hover:bg-red-900/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Eliminar Usuario
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.users.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-600 text-sm font-medium rounded-md text-gray-300 bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
