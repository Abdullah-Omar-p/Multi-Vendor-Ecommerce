<?php

namespace App\Http\Controllers\AuthControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Mail;

class SignUpController extends Controller
{
    public function checkEmail(Request $request)
    {
        $validatedData = Validator::make(($request->all()),[
            'email'   => 'required|email|unique:users',
        ]);

        if ($validatedData->fails()) {
            return $validatedData->errors();
        }

        $randomNumber = mt_rand(100000, 999999);

        $sendCode = Mail::to($request->email)->send(new RegisterMail($randomNumber));

        $existingRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if ($existingRecord) {
            // Update the existing record
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->update(['token' => $randomNumber]);
        } else {
            // Insert a new record
            $create_resets = DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $randomNumber,
            ]);
        }

        if (!$sendCode) {
            return response()->json([
                'status' => 'failed',
                'message' => 'error while sending code, try again',
            ]);
        }

        return response()->json(['message' => 'we sent an email with code of 6 numbers to your email']);
    }

    public function signup(SignUpRequest $request)
    {
        $_resets =  DB::table('password_reset_tokens')
        ->where('token', $request->token)
        ->first();

        if ($_resets) {
            try {
                $user = User::create([
                    'f_name' => $request->f_name,
                    'l_name' => $request->l_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'age' => $request->age,
                    'address' => $request->address,
                    'gender' => $request->gender,
                ]);
                $user->assignRole('customer');

                Cart::create(['user_id' => $user->id]);
                return response()->json([
                    'status' => true,
                    'message' => 'User Registered Successfully',
                    'token' => $user->createToken("API TOKEN")->plainTextToken,
                ], 200);

            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage()
                ], 500);
            }
        }else {
            return response()->json([
                'status' => false,
                'message' => 'invalid code'
            ], 500);
        }
    }
}
