<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class AuthService
{
    public function register(array $attributes)
    {
        $attributes['password'] = bcrypt(Arr::get($attributes, 'password'));
        $user = User::create($attributes);
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        $payload =  [
            'token' => $tokenResult->accessToken,
            'user' => $user,
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ];
    }
}
