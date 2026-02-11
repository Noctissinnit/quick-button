<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.cards');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        Log::info('Login attempt', ['username' => $credentials['username']]);

        $user = User::where('username', $credentials['username'])->first();

        if (!$user) {
            Log::warning('User not found', ['username' => $credentials['username']]);
            return back()->withErrors(['credentials' => 'Username atau password salah']);
        }

        Log::info('User found', ['user_id' => $user->id]);

        if (!Hash::check($credentials['password'], $user->password)) {
            Log::warning('Password mismatch for user', ['user_id' => $user->id]);
            return back()->withErrors(['credentials' => 'Username atau password salah']);
        }

        if (!$user->hasRole('admin')) {
            Log::warning('Non-admin user trying to login', ['user_id' => $user->id]);
            return back()->withErrors(['credentials' => 'Akses hanya untuk admin']);
        }

        Log::info('Login successful', ['user_id' => $user->id, 'username' => $user->username]);

        session([
            'admin_logged_in' => true,
            'admin_id' => $user->id,
            'admin_username' => $user->username,
            'admin_name' => $user->name,
        ]);

        return redirect()->route('admin.cards')->with('success', 'Login berhasil');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Logout berhasil');
    }
}
