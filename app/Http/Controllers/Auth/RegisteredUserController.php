<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;
use Illuminate\Support\Facades\Redis;

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
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'phoneNumber' => $validated['phoneNumber'],
            'bio' => $validated['bio'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // event(new Registered($user));

        $otp = rand(100000, 999999);

        Redis::setex('otp:' . $validated['phoneNumber'], 600, $otp);

        $storedToken = Redis::get('otp:' . $validated['phoneNumber']);

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
