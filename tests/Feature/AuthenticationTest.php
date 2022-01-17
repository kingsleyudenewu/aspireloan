<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_successful_registration()
    {
        $this->withExceptionHandling();
        $userData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "password" => "demo12345",
            "password_confirmation" => "demo12345"
        ];

        $this->json('POST', 'api/auth/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonFragment([
                'message' => 'Successful, welcome to Aspire Loan'
            ]);
    }

    public function test_validation_on_signups()
    {
        $this->withExceptionHandling();
        $this->json('POST', 'api/auth/register', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => 'Validation error occurred',
                "status" => 422,
                "error" => [
                    "The name field is required.",
                    "The email field is required.",
                    "The password field is required.",
                ]
            ]);
    }
}
