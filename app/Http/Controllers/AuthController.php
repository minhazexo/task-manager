<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        \Log::info('📥 Register request received', ['request' => $request->all()]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        \Log::info('✅ User registered successfully', ['id' => $user->id, 'email' => $user->email]);

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ], 201);
    }

    /**
     * Login user and return token
     */
    public function login(Request $request)
    {
        \Log::info('🔐 Login attempt', ['request' => $request->all()]);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            \Log::warning('❌ Login failed - Invalid credentials', ['email' => $request->email]);
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        \Log::info('✅ Login successful', ['email' => $user->email, 'id' => $user->id]);

        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => $user
        ]);
    }

    /**
     * Logout user by deleting all tokens
     */
    public function logout(Request $request)
    {
        \Log::info('🚪 Logout request received', ['user_id' => $request->user()->id]);

        $request->user()->tokens()->delete();

        \Log::info('✅ User logged out successfully', ['user_id' => $request->user()->id]);

        return response()->json(['message' => 'Logged out successfully']);
    }
}
