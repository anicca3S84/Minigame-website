<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'imageUrl',
        'category_id',
        'gameType',
        'url',
        'isActive',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function levels()
    {
        return $this->hasMany(Level::class);
    }
}
