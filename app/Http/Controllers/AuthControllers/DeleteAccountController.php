<?php

namespace App\Http\Controllers\AuthControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteAccountController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $user->delete();

        auth()->logout();
//        return redirect()->route('home')->with('status', 'Your account has been successfully deleted.');

        return response()->json([
            'status' => 'success',
            'message' => 'Your account has been successfully deleted.',
        ]);
    }
}
