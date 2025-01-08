<?php

namespace App\Http\Controllers\AuthControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $accessToken = $request->bearerToken();

        // Get access token from database
        $token = PersonalAccessToken::findToken($accessToken);

        // Revoke token
        $token->delete();

        if ($token) {
            return response()->json(['message'=>'user logged out successfully']);
        }
    }
}
