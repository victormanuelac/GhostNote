<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /**
     * Relación con usuarios
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Scope para buscar por nombre
     */
    public function scopeByName($query, string $name)
    {
        return $query->where('name', $name);
    }

    /**
     * Verificar si es rol de administrador
     */
    public function isAdmin(): bool
    {
        return $this->name === 'admin';
    }

    /**
     * Verificar si es rol de usuario
     */
    public function isUser(): bool
    {
        return $this->name === 'user';
    }
}
