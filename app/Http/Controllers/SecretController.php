<?php

namespace App\Http\Controllers;

use App\Services\SecretService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SecretController extends Controller
{
    protected $secretService;

    public function __construct(SecretService $secretService)
    {
        $this->secretService = $secretService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'description' => 'nullable|string|max:255',
            'ttl' => 'nullable|integer|min:1', // Time to live in minutes
            'max_views' => 'required|integer|min:1',
        ], [
            'content.required' => 'El contenido es obligatorio.',
            'content.string' => 'El contenido debe ser texto.',
            'description.string' => 'La descripción debe ser texto.',
            'description.max' => 'La descripción no puede tener más de 255 caracteres.',
            'ttl.integer' => 'El tiempo de vida debe ser un número entero.',
            'ttl.min' => 'El tiempo de vida debe ser al menos 1 minuto.',
            'max_views.required' => 'El número máximo de vistas es obligatorio.',
            'max_views.integer' => 'El número máximo de vistas debe ser un número entero.',
            'max_views.min' => 'El número máximo de vistas debe ser al menos 1.',
        ]);

        $expiration = null;
        if (!empty($validated['ttl'])) {
            $expiration = Carbon::now()->addMinutes((int) $validated['ttl']);
        }

        $secret = $this->secretService->createSecret(
            $validated['content'],
            $expiration,
            $validated['max_views'],
            $request->user()->id,
            $validated['description'] ?? null
        );

        $url = route('secret.confirm', ['id' => $secret->id]);

        if ($request->wantsJson()) {
            return response()->json(['url' => $url, 'id' => $secret->id], 201);
        }

        return redirect()->route('dashboard')->with('created_url', $url);
    }

    public function confirm($id)
    {
        $secret = \App\Models\Secret::find($id);
        $isAvailable = true;

        if (!$secret || $secret->is_burned || ($secret->expiration_time && $secret->expiration_time->isPast()) || $secret->current_views >= $secret->max_views) {
            $isAvailable = false;
        }

        return view('secret.confirm', ['id' => $id, 'isAvailable' => $isAvailable]);
    }

    public function show(Request $request, $id)
    {
        try {
            $data = $this->secretService->retrieveSecret($id);
            
            if ($request->wantsJson()) {
                return response()->json(['content' => $data['content']]);
            }

            return view('secret.show', ['content' => $data['content']]);
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 404);
            }
            return response()->view('errors.404', [], 404);
        }
    }
}
