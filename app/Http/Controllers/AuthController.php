<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $authService = resolve(AuthService::class);
    }

    public function register(RegisterRequest $request)
    {

    }
}
