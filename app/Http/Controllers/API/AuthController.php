<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   // Register
   public function register(Request $request)
   {
       $request->validate([
           'name'     => 'required|string|min:5|max:255',
           'email'    => 'required|email|min:5|max:255|unique:users',
           'password' => 'required|string|min:6|max:255|confirmed',
       ]);

       $user = User::create([
           'name'     => $request->name,
           'email'    => $request->email,
           'password' => Hash::make($request->password),
       ]);

       $token = $user->createToken('apptoken')->plainTextToken;

       return response()->json([
           'User'=> $user,
           'status' => true,
           'message' => 'User registered successfully',
           'token' => $token
       ], 201);
   }

   // Login
   public function login(Request $request)
   {
       $request->validate([
           'email'    => 'required|email',
           'password' => 'required',
       ]);

       $user = User::where('email', $request->email)->first();

       if (! $user || ! Hash::check($request->password, $user->password)) {
           return response()->json([
               'status' => false,
               'message' => 'Invalid credentials',
           ], 401);
       }

       $token = $user->createToken('apptoken')->plainTextToken;

       return response()->json([
           'status' => true,
           'message' => 'Login successful',
           'token' => $token,
       ]);
   }

   // Logout
   public function logout(Request $request)
   {
       $request->user()->tokens()->delete();

       return response()->json([
           'status' => true,
           'message' => 'Logged out successfully',
       ]);
   }
}
