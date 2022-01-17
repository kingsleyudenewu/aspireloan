<?php

namespace Tests\Feature;

use App\Models\LoanApplication;
use App\Models\LoanType;
use App\Models\User;
use Tests\TestCase;

class LoanApplicationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_application()
    {
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $loanType = LoanType::factory()->create();

        $this->actingAs($user, 'api');

        $payload = [
            'loan_type_id' => $loanType->id,
            'principal' => 10000,
            'tenure' => 4
        ];
        $this->json('POST', 'api/my-loans/apply', $payload, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonFragment([
                'message' => 'Loan application submitted'
            ]);
    }

    public function test_loan_approval()
    {
        $user = User::factory()->create();
        $loanType = LoanType::factory()->create();

        $this->actingAs($user, 'api');

        $payload = [
            'user_id' => $user->id,
            'loan_type_id' => $loanType->id,
            'principal' => '100000',
            'total_amount' => '120000',
            'tenure' => '10',
            'status' => LoanApplication::PENDING
        ];

        $application = LoanApplication::create($payload);


        $this->json('POST', 'api/my-loans/approve',
            ['loan_application_id' => $application->id],
            ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Loan approval successful'
            ]);
    }

    /**
     * @skip
     */
    public function test_loan_remittance()
    {
        $this->markTestSkipped();

        $user = User::factory()->create();
        $loanType = LoanType::factory()->create();
        $this->actingAs($user, 'api');
        $application = LoanApplication::factory()
            ->withApproveLoan()
            ->withSchedule()
            ->create();

        $this->json('POST', 'api/my-loans/approve',
            ['loan_application_id' => $application->id],
            ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Loan approval successful'
            ]);
    }

}
