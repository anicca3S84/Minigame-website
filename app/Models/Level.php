<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'level_number',
        'name',
        'item_a_count',
        'item_b_count',
        'start_x',
        'start_y',
        'end_x',
        'end_y',
        'last',
    ];
}
