<?php

namespace App\Services\Auth;

use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisterService
{
    public function __construct(
        private readonly User $user
    ) {}

    public function handle(array $userData): User
    {
        $user = User::create($userData);
        
        event(new Registered($user));

        return $user;
    }
}

