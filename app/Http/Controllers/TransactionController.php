<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function deposit(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = Auth::user();
        $user->balance += $request->amount;
        $user->save();

        return response()->json(['message' => 'Deposit successful', 'balance' => $user->balance], 200);
    }


    public function withdraw(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = Auth::user();
        if($user->balance < $request->amount){
            return response()->json(['message' => 'Insufficient balance'], 400);
        }
        $user->balance -= $request->amount;
        $user->save();

        return response()->json(['message' => 'Withdrawal successful', 'balance' => $user->balance], 200);
    }


}
