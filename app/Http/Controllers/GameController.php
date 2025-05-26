<?php

namespace App\Http\Controllers;

use App\Models\LeaderboardEntries;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Level;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Support\Facades\Log;
use App\Models\Obstacle;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function show($gameSlug, $levelSlug)
{
    $game = Game::where('url', $gameSlug)->firstOrFail();

    if ($levelSlug != 0) {
        $level = Level::where('game_id', $game->id)
                      ->where('level_number', $levelSlug)
                      ->firstOrFail();
        $obstacles = Obstacle::where('level_id', $level->id)->get();

        return view("$gameSlug", compact('game', 'level', 'obstacles'));
    } else {
        $topics = $game->topics;
        if($topics === null){
            return view("$gameSlug", compact('game'));
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

    public function saveScore(Request $request) {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'score' => 'required|integer|min:0',
        ]);
    $existing = LeaderboardEntries::where('game_id', $request->game_id)
                                ->where('user_id', Auth::id())
                                ->first();

    if ($existing) {
        // Nếu điểm mới cao hơn thì cập nhật
        if ($request->score > $existing->score) {
            $existing->score = $request->score;
            $existing->save();
            return response()->json(['message' => 'Đã cập nhật điểm mới cao hơn']);
        } else {
            return response()->json(['message' => 'Điểm mới thấp hơn, không lưu'], 200);
        }
    } else {
        // Nếu chưa có bản ghi thì tạo mới
        LeaderboardEntries::create([
            'game_id' => $request->game_id,
            'user_id' => Auth::id(),
            'score' => $request->score
        ]);

        return response()->json(['message' => 'Đã lưu điểm mới']);
    }
    }
    public function getTopScores($gameId) {
        $topScores = LeaderboardEntries::with('user')
        ->where('game_id', $gameId)
        ->orderBy('score', 'desc')
        ->limit(10)
        ->get()
        ->map(function ($entry) {
            return [
                'user_name' => $entry->user->username ?? 'Unknown',
                'score' => $entry->score,
                'recordAt' => $entry->recordAt,
            ];
        });
        return response()->json($topScores);
    }
    public function searchGame($gameName) {
        $game = Game::where('name', 'LIKE', '%' . $gameName . '%')->first();
        if($game) {
            return response()->json(['id' => $game->id]);
        }
        return response()->json(['error' => 'Game not found'], 404);
    }
}
