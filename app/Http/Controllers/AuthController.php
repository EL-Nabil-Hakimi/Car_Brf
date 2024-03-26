<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    protected $user;
    public function __construct(){
        $this->user = new User();
    }

    public function login(Request $request)
    {
        $checkuser = $request->only('email', 'password');
        
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['error' => 'Email not found'], 401);
        }
    
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Incorrect password'], 401);
        }
    
        $token = JWTAuth::attempt($checkuser);
    
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        return response()->json([
            'success' => 'Welcome ' . auth()->user()->username,
            'token' => $token,
            'user' => auth()->user()
        ], 200);
    }

}
