<?php

namespace App\Http\Controllers;

use App\Models\SessionLog;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('username', $username)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $sessionLog = new SessionLog();
        $sessionLog->user_id = $user->user_id;
        $sessionLog->login_time = now();
        $sessionLog->save();

        $token = $user->createToken('session')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ]);
    }
}
