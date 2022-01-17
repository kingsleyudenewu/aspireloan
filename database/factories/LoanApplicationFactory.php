<?php

namespace Database\Factories;

use App\Models\LoanApplication;
use App\Models\LoanType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class LoanApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'loan_type_id' => LoanType::factory()->create()->id,
            'principal' => $this->faker->numberBetween(10000, 1000000),
            'tenure' => $this->faker->randomDigitNotNull,
            'total_amount' => $this->faker->numberBetween(10000, 1000000),
            'status' => LoanApplication::APPROVED,
            'approved_date' => now()->toDateString()
        ];
    }

    /**
     *
     *
     * @return LoanApplicationFactory
     */
    public function withApproveLoan(): LoanApplicationFactory
    {
        return $this->afterCreating(function (LoanApplication $loanApplication){
//            $loanApplication->status = LoanApplication::APPROVED;
//            $loanApplication->approved_date = now()->toDateString();
            $loanApplication->make([
                'status' => LoanApplication::APPROVED,
                'approved_date' => now()->toDateString()
            ]);
        });
    }

    /**
     * Setting a schedule for approved loan application
     *
     * @return LoanApplicationFactory
     */
    public function withSchedule(): LoanApplicationFactory
    {
        return $this->afterCreating(function (LoanApplication $loanApplication){
            if ($loanApplication->status == LoanApplication::APPROVED) {
                for ($i=0; $i<$loanApplication->tenure; $i++) {
                    $loanApplication->loanSchedule()->create([
                        [
                            'loan_application_id' => $loanApplication->id,
                            'principal_balance' => 120000,
                            'interest' => 10,
                            'due_date' => now()->addWeeks(1)->toDateString(),
                        ]
                    ]);
                }
            }
        });
    }
}
