<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Game;

class DashboardController extends Controller
{

    public function index()
    {
        $games = Game::where('isActive', 1)->get();
        $user = Auth::user();
        return view('dashboard', compact('user', 'games'));
    }
    public function leaderboard() {
        return view('leaderboard');
    }


}
