<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = Str::random(60);
            $user->api_token = hash('sha256', $token);
            $user->save();

            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout()
    {
        $user = auth()->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json(['message' => 'Logged out']);
    }
}
