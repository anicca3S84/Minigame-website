<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obstacle extends Model
{
    use HasFactory;

    protected $fillable = ['level_id', 'x', 'y'];

}
