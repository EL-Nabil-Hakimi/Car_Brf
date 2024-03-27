<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthController extends Controller
{
    //
    protected $user;
    public function __construct(){
        $this->user = new User();
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        // Find the user by email
        $user = User::where('email', $credentials['email'])->first();
    
        // Check if the user exists
        if (!$user) {
            return response()->json(['error' => 'Email not found'], 401);
        }
    
        // Check if the password is correct
        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Incorrect password'], 401);
        }
    
        try {
            // Generate a JWT token
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token: ' . $e->getMessage()], 500);
        }
    
        // Return success response with token and user data
        return response()->json([
            'success' => 'Welcome ' . $user->name,
            'token' => $token,
            'user' => $user
        ], 200);
    }
}
