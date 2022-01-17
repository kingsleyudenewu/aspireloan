<?php

namespace Tests\Feature;

use App\Models\LoanType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoanTypeTest extends TestCase
{
    /**
     * Test fetching of all loan types
     *
     * @return void
     */
    public function test_fetch_all_loan_types()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        LoanType::factory()->create();

        $this->json('GET', 'api/loan-type', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Loan Types retrieved successfully'
            ]);
    }

    /**
     * Test creation of a loan type
     */
    public function test_create_loan_type()
    {
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $payload = [
            'name' => 'Pay Day Loan',
            'interest' => 10
        ];
        $this->json('POST', 'api/loan-type/create', $payload, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonFragment([
                'message' => 'Loan type created successfully'
            ]);
    }


}
