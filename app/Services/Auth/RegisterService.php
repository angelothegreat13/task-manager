<?php

namespace App\Services\Auth;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisterService
{
    public function __construct(
        private readonly User $user
    ) {}

    public function handle(array $userData): void
    {
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password'])
        ]);

        event(new Registered($user));

        Auth::login($user);
    }
}

