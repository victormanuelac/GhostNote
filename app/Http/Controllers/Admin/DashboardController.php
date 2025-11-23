<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Secret;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Mostrar el panel de administración
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'inactive_users' => User::where('is_active', false)->count(),
            'total_secrets' => Secret::count(),
            'active_secrets' => Secret::where('is_burned', false)->count(),
            'burned_secrets' => Secret::where('is_burned', true)->count(),
            'secrets_today' => Secret::whereDate('created_at', today())->count(),
        ];

        $recent_users = User::latest()->take(5)->get();
        $recent_secrets = Secret::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_secrets'));
    }

    /**
     * Obtener estadísticas en formato JSON
     */
    public function stats()
    {
        return response()->json([
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_secrets' => Secret::count(),
            'active_secrets' => Secret::where('is_burned', false)->count(),
            'burned_secrets' => Secret::where('is_burned', true)->count(),
        ]);
    }
}
