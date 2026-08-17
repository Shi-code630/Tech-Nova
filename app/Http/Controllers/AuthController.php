<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show login page
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        // Check whether account exists
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'No account was found with this email address.',
            ]);
        }

        // Check whether account is active
        if (!$user->status) {
            throw ValidationException::withMessages([
                'email' => 'Your account has been deactivated. Please contact support.',
            ]);
        }

        // Attempt login
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'The email or password is incorrect.',
            ]);
        }

        // Prevent session fixation
        $request->session()->regenerate();

        // Return the user to the page they originally wanted
        return redirect()->intended(route('user.dashboard'));
    }

    /**
     * Show registration page
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        /*
         * Your User model already has a password mutator:
         *
         * setPasswordAttribute()
         *
         * Therefore we DO NOT use Hash::make() here.
         */
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => $validated['password'],
            'reward_points' => 0,
            'status' => true,
        ]);

        // Automatically log the newly registered user in
        Auth::login($user);

        // Regenerate session for security
        $request->session()->regenerate();

        return redirect()->intended(route('user.dashboard'));
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Destroy the old session
        $request->session()->invalidate();

        // Generate a new CSRF token
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
