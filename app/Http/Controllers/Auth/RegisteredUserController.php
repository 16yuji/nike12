<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'role'     => 'customer', // đảm bảo có cột 'role' trong users
        ]);

        // Nếu User::$fillable chưa có 'role', dùng cách sau thay cho dòng trên:
        // $user = User::create([
        //   'name' => $validated['name'],
        //   'email' => strtolower($validated['email']),
        //   'password' => Hash::make($validated['password']),
        // ]);
        // $user->forceFill(['role' => 'customer'])->save();

        event(new Registered($user));
        Auth::login($user);

        // Nếu bạn KHÔNG có route('dashboard'), dùng 'home' (đã có trong patch)
        return redirect()->intended(route('home'));

        // Nếu muốn về dashboard, đảm bảo bạn đã có route('dashboard'), rồi dùng:
        // return redirect()->intended(route('dashboard'));
    }
}
