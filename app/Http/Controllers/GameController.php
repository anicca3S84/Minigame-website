<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Level;
use App\Models\Obstacle;


class GameController extends Controller
{
    public function show($gameSlug, $levelSlug)
    {
        $game = Game::where('url', $gameSlug)->firstOrFail();
        $level = Level::where('game_id', $game->id)
                        ->where('level_number', $levelSlug)
                        ->firstOrFail();
        $obstacles = Obstacle::where('level_id', $level->id)->get();

        return view('test', compact('game', 'level', 'obstacles'));
    }
}