<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secret extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'content',
        'description',
        'expiration_time',
        'max_views',
        'current_views',
        'is_burned',
        'user_id',
        'viewed_at',
    ];

    protected $casts = [
        'expiration_time' => 'datetime',
        'viewed_at' => 'datetime',
        'is_burned' => 'boolean',
        'max_views' => 'integer',
        'current_views' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
