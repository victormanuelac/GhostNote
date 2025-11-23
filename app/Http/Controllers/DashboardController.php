<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $secrets = Auth::user()->secrets()->latest()->get();
        return view('dashboard', compact('secrets'));
    }

    public function status()
    {
        $secrets = Auth::user()->secrets()->latest()->get()->map(function ($secret) {
            return [
                'id' => $secret->id,
                'description' => $secret->description ?? 'Sin descripción',
                'created_at_human' => $secret->created_at->diffForHumans(),
                'viewed_at_human' => $secret->viewed_at ? $secret->viewed_at->diffForHumans() : '-',
                'expiration_human' => $secret->expiration_time ? $secret->expiration_time->diffForHumans() : '∞',
                'is_burned' => $secret->is_burned,
                'viewed_at' => $secret->viewed_at,
                'confirm_url' => route('secret.confirm', $secret->id),
            ];
        });

        return response()->json($secrets);
    }
}
