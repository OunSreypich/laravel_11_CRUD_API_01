<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    //Register ,login
    public function register(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);
    
            // Create a new user
            $user = \App\Models\User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);
    
            // Generate token using Sanctum
            $token = $user->createToken('auth_token')->plainTextToken;
    
            // Return response
            return response()->json([
                'token'=> $token,
                'token_type' => 'Bearer',
                'user' => $user,
                'message' => 'User created successfully',
               
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating user: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to create user'], 500);
        }
    }
    
    public function login(Request $request)
    {
        // validate the request
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required',
        ]);
    
        // check if user exists
        $user = \App\Models\User::where('email', $request->email)->first();

        if(!empty($user)){
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('my_token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'token' => $token, 
                    'token_type' => 'Bearer', 
                    'user' => $user, 
                    'message' => 'User logged in successfully',
                    'data' => [],
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Wrong password',
                    'data' => [],
                ]);
            };
        }else{
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'data' => [],
            ]);
        }
    }
}
