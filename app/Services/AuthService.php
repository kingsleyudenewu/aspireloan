<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class AuthService
{
    use ApiResponse;

    /**
     * @param array $attributes
     */
    public function registerUser(array $attributes)
    {
        $attributes['password'] = bcrypt(Arr::get($attributes, 'password'));
        $user = User::create($attributes);
        $payload = $this->createToken($user);
        return $this->ok($payload);
    }

    public function loginUser(array $attributes)
    {
        if (!auth()->attempt($attributes)) {
            abort(400, 'Invalid login credentials inputted');
        }
        $payload = $this->createToken(auth()->user());
        return $this->ok($payload);
    }

    /**
     * Format passport token to be generated to a user
     * @param User $user
     * @return array
     */
    private function createToken(User $user): array
    {
        $tokenResult = $user->createToken('Personal Access Token For Aspire Loan');
        $token = $tokenResult->token;

        $token->expires_at = Carbon::now()->addHours(1);
        $token->save();
        return  [
            'token' => $tokenResult->accessToken,
            'user' => $user,
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ];
    }
}
