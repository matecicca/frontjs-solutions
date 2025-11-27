<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'slug',
        'resumen',
        'contenido',
        'imagen',
    ];

    /**
     * Relación: Un post pertenece a un usuario (autor).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
