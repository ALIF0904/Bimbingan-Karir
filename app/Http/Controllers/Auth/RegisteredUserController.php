<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman register
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Proses register
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'user', // 🔥 SET ROLE DEFAULT
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // 🔥 AUTO LOGIN SETELAH REGISTER
        Auth::login($user);

        // 🔥 ARAHKAN KE DASHBOARD PEMBELI
        return redirect()->route('user.dashboard');
    }
}
