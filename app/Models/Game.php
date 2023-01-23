<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class Game extends Model
{
    use HasFactory;

    public function play($bet): JsonResponse
    {
        $user = Auth::user();
        if($user->balance < $bet) {
            return response()->json(['error' => 'Insufficient balance'], 400);
        }
        $user->decrement('balance', $bet);
        $result = rand(0,1);
        if($result == 1) {
            $user->increment('balance', $bet * 2);
            $this->result = 'win';
        } else {
            $this->result = 'lose';
        }
        $this->user_id = $user->id;
        $this->bet_amount = $bet;
        $this->save();
        return response()->json(['message' => 'Game played', 'result' => $this->result, 'new_balance' => $user->balance]);
    }
}
