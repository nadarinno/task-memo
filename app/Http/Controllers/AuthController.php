<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:100'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()
                ->route('tasks.index')
                ->with('success', 'Account created successfully.');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Registration failed. Please check your information and try again.');
        }
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ]);

            $remember = $request->boolean('remember');

            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();

                return redirect()
                    ->route('tasks.index')
                    ->with('success', 'Logged in successfully.');
            }

            return back()
                ->withInput()
                ->with('error', 'Invalid email or password.');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Login failed. Please try again.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Logged out successfully.');
    }
}