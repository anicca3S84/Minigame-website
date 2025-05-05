<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Level;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Support\Facades\Log;
use App\Models\Obstacle;


class GameController extends Controller
{
    public function show($gameSlug, $levelSlug)
{
    $game = Game::where('url', $gameSlug)->firstOrFail();

    if ($levelSlug == 1) {
        $level = Level::where('game_id', $game->id)
                      ->where('level_number', $levelSlug)
                      ->firstOrFail();
        $obstacles = Obstacle::where('level_id', $level->id)->get();

        return view("$gameSlug", compact('game', 'level', 'obstacles'));
    } else {
        $topics = $game->topics;
        if($topics === null){
            return view("$gameSlug");
        }else{
            return view("$gameSlug", compact('topics', 'game'));

        }
    }
}



    public function getQuestions($gameSlug, $topicSlug)
{
    try {
        // Tìm game dựa trên slug
        $game = Game::where('url', $gameSlug)->firstOrFail();
        
        // Tìm topic dựa trên slug và game_id
        $topic = Topic::where('slug', $topicSlug)->where('game_id', $game->id)->firstOrFail();
        
        // Lấy danh sách câu hỏi
        $questions = Question::where('topic_id', $topic->id)->get();
        
        return response()->json($questions);
    } catch (\Exception $e) {
        Log::error('Error in getQuestions: ' . $e->getMessage());
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}

}
