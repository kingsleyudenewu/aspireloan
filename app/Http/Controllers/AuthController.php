<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Support\Arr;

class AuthController extends Controller
{
    protected $authService;

    public function __construct()
    {
        $this->authService = resolve(AuthService::class);
    }

    public function register(RegisterRequest $request)
    {
        $userSignUp = $this->authService->registerUser($request->toArray());
        if (Arr::get($userSignUp, 'status')) {
            return $this->createdResponse('Successful, welcome to Aspire Loan',
                Arr::get($userSignUp, 'data'));
        }
    }

    public function login(LoginRequest $request)
    {
        $payload = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $userLogin = $this->authService->loginUser($payload);
        if (Arr::get($userLogin, 'status')) {
            return $this->successResponse('Login successful to Aspire Loan',
                Arr::get($userLogin, 'data'));
        }
    }
}
