<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    use HasFactory;

    protected $table = 'albums';

    protected $fillable = [
        'user_id',
        'name',
        'image'
    ];

    public function songs(): HasMany
    {
        return $this->hasMany(Song::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
