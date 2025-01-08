<?php

namespace App\Http\Controllers\AuthControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;

class PasswordResetLinkController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        // $status = Password::sendResetLink(
        //     $request->only('email'),
        // );
        $randomNumber = mt_rand(100000, 999999);

        // dd($randomNumber);

        $sendCode = Mail::to($request->email)->send(new ResetPasswordMail($randomNumber));

        // dd($sendCode);

        if (!$sendCode) {
            return response()->json([
                'status' => 'failed',
                'message' => 'error while sending code, try again',
            ]);
        }

        // if ($status != Password::RESET_LINK_SENT) {
        //     throw ValidationException::withMessages([
        //         'email' => [__($status)],
        //     ]);
        // }

        return response()->json(['message' => 'we sent an email with code of 6 numbers to your email']);
    }
}
