<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::where('game_id', 5)->get();

        return view('spelling-word', compact('topics'));
    }
}
