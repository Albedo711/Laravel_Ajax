<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function showDashboard()
    {
        $userName = auth()->user()->name;
        return view('dashboard', compact('userName'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return response()->json(['success' => true, 'user' => $user]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(['success' => true, 'user' => Auth::user()]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['success' => true]);
    }

    public function dashboardData()
    {
        if (Auth::check()) {
            return response()->json(['success' => true, 'user' => Auth::user()]);
        }
        return response()->json(['success' => false]);
    }
}