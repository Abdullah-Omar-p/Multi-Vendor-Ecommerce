<?php

namespace App\Http\Controllers\AuthControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class NewPasswordController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::where('email', $request->email)->first();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        if (!$user) {
            return response()->json([
                'status'=> 'fails',
                'message' => 'error while updating new password , try again',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'password updated successfully',
        ]);
    }
}

