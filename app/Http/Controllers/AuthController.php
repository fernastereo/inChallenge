<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'       => 'Access granted',
            'user'          => $user,
            'access_token'  => $token,
            'token_type'    => 'Bearer',
        ]);
    }

    public function logout()
    {
        auth()->user()?->tokens()->delete();

        return [
            'message' => 'Logout successfull. Token was deleted.'
        ];
    }
}
