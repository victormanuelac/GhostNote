<?php

namespace App\Services;

use App\Models\Secret;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Exception;

class SecretService
{
    /**
     * Create a new secret.
     *
     * @param string $content
     * @param Carbon|null $expiration
     * @param int $maxViews
     * @param int|null $userId
     * @param string|null $description
     * @return Secret
     */
    public function createSecret(string $content, ?Carbon $expiration, int $maxViews = 1, ?int $userId = null, ?string $description = null): Secret
    {
        return Secret::create([
            'content' => Crypt::encryptString($content),
            'description' => $description,
            'expiration_time' => $expiration,
            'max_views' => $maxViews,
            'current_views' => 0,
            'is_burned' => false,
            'user_id' => $userId,
        ]);
    }

    /**
     * Retrieve a secret, increment view count, and burn if necessary.
     *
     * @param string $id
     * @return array{content: string, secret: Secret}
     * @throws Exception
     */
    public function retrieveSecret(string $id): array
    {
        return DB::transaction(function () use ($id) {
            // Lock the row for update to prevent race conditions
            $secret = Secret::where('id', $id)->lockForUpdate()->firstOrFail();

            if ($secret->is_burned) {
                throw new Exception('El secreto ya ha sido quemado.');
            }

            if ($secret->expiration_time && $secret->expiration_time->isPast()) {
                $secret->update(['is_burned' => true]);
                throw new Exception('El secreto ha expirado.');
            }

            if ($secret->current_views >= $secret->max_views) {
                 $secret->update(['is_burned' => true]);
                 throw new Exception('Se ha alcanzado el límite de vistas del secreto.');
            }

            // Increment view count
            $secret->current_views++;
            
            // Set viewed_at if not already set
            if (!$secret->viewed_at) {
                $secret->viewed_at = Carbon::now();
            }
            
            // Check if this view burns it
            if ($secret->current_views >= $secret->max_views) {
                $secret->is_burned = true;
            }
            
            $secret->save();

            // Decrypt content
            try {
                $decryptedContent = Crypt::decryptString($secret->content);
            } catch (\Exception $e) {
                throw new Exception('No se pudo desencriptar el secreto.');
            }

            return [
                'content' => $decryptedContent,
                'secret' => $secret
            ];
        });
    }
}
