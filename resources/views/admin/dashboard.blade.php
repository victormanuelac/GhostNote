@extends('admin.layout')

@section('header', 'Dashboard de Administración')

@section('content')
<div class="px-4 sm:px-0">
    <!-- Estadísticas -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Total Usuarios -->
        <div class="overflow-hidden rounded-lg bg-gradient-to-br from-blue-900 to-blue-800 border border-blue-700 shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="truncate text-sm font-medium text-blue-200">Total Usuarios</dt>
                            <dd class="text-3xl font-semibold text-white">{{ $stats['total_users'] }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-3 text-sm text-blue-200">
                    <span class="text-green-300">{{ $stats['active_users'] }}</span> activos / 
                    <span class="text-red-300">{{ $stats['inactive_users'] }}</span> inactivos
                </div>
            </div>
        </div>

        <!-- Total Secretos -->
        <div class="overflow-hidden rounded-lg bg-gradient-to-br from-purple-900 to-purple-800 border border-purple-700 shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="truncate text-sm font-medium text-purple-200">Total Secretos</dt>
                            <dd class="text-3xl font-semibold text-white">{{ $stats['total_secrets'] }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-3 text-sm text-purple-200">
                    <span class="text-green-300">{{ $stats['active_secrets'] }}</span> activos / 
                    <span class="text-red-300">{{ $stats['burned_secrets'] }}</span> quemados
                </div>
            </div>
        </div>

        <!-- Secretos Hoy -->
        <div class="overflow-hidden rounded-lg bg-gradient-to-br from-green-900 to-green-800 border border-green-700 shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="truncate text-sm font-medium text-green-200">Secretos Hoy</dt>
                            <dd class="text-3xl font-semibold text-white">{{ $stats['secrets_today'] }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-3 text-sm text-green-200">
                    Creados en las últimas 24h
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="overflow-hidden rounded-lg bg-gradient-to-br from-indigo-900 to-indigo-800 border border-indigo-700 shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="truncate text-sm font-medium text-indigo-200">Acciones Rápidas</dt>
                        </dl>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-3 py-2 border border-indigo-500 text-sm leading-4 font-medium rounded-md text-indigo-200 bg-indigo-900/50 hover:bg-indigo-800 transition">
                        + Nuevo Usuario
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Usuarios Recientes y Secretos Recientes -->
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
        <!-- Usuarios Recientes -->
        <div class="bg-gray-800 shadow rounded-lg border border-gray-700">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-white mb-4">Usuarios Recientes</h3>
                <div class="flow-root">
                    <ul role="list" class="-my-5 divide-y divide-gray-700">
                        @forelse($recent_users as $user)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center">
                                            <span class="text-white font-semibold">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">{{ $user->name }}</p>
                                        <p class="truncate text-sm text-gray-400">{{ $user->email }}</p>
                                    </div>
                                    <div>
                                        @if($user->isAdmin())
                                            <span class="inline-flex items-center rounded-full bg-purple-900/50 px-2 py-1 text-xs font-medium text-purple-300 ring-1 ring-inset ring-purple-700">Admin</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-gray-700 px-2 py-1 text-xs font-medium text-gray-300 ring-1 ring-inset ring-gray-600">Usuario</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-center text-gray-400">No hay usuarios recientes</li>
                        @endforelse
                    </ul>
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.users.index') }}" class="flex w-full items-center justify-center rounded-md bg-gray-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-600">
                        Ver todos los usuarios
                    </a>
                </div>
            </div>
        </div>

        <!-- Secretos Recientes -->
        <div class="bg-gray-800 shadow rounded-lg border border-gray-700">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-white mb-4">Secretos Recientes</h3>
                <div class="flow-root">
                    <ul role="list" class="-my-5 divide-y divide-gray-700">
                        @forelse($recent_secrets->take(5) as $secret)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($secret->is_burned)
                                            <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        @else
                                            <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">{{ $secret->description ?? 'Sin descripción' }}</p>
                                        <p class="truncate text-sm text-gray-400">Por {{ $secret->user->name ?? 'Anónimo' }}</p>
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $secret->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-center text-gray-400">No hay secretos recientes</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
