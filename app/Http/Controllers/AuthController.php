<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'No account was found with this email address.',
            ]);
        }

        if (!$user->status) {
            throw ValidationException::withMessages([
                'email' => 'Your account has been deactivated. Please contact support.',
            ]);
        }

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'The email or password is incorrect.',
            ]);
        }

        $request->session()->regenerate();

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

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => $validated['password'],
            'reward_points' => 0,
            'status' => true,
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended(route('user.dashboard'));
    }


    /**
     * Update Profile
     */
    public function updateProfile(Request $request)
    {
        // Currently logged-in user
        $user = Auth::user();

        // If user is not logged in
        if (!$user) {
            return redirect()
                ->route('login')
                ->with('error', 'Please login first.');
        }

        // Validate
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'phone' => [
                'nullable',
                'string',
                'max:20'
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
        ]);

        // Update name
        $user->name = $validated['name'];

        // Update phone
        $user->phone = $validated['phone'] ?? null;


        // Profile Image
        if ($request->hasFile('image')) {

            // Delete old image
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            // Save new image
            $user->image = $request
                ->file('image')
                ->store('users', 'public');
        }


        // Save user
        $user->save();


        return redirect()
            ->route('user.profile')
            ->with('success', 'Profile updated successfully.');
    }


    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
