<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaderboardEntries extends Model
{
    protected $fillable = [
        'user_id', 
        'game_id', 
        'score'
    ];
    protected $table = 'leaderboardentries';
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
