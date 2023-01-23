<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function play(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'bet' => 'required|numeric|min:0'
        ]);

        $game = new Game();
        return $game->play($validatedData['bet']);
    }
}
