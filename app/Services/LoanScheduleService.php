<?php

namespace App\Services;

use App\Contracts\LoanScheduleInterface;
use App\Models\LoanApplication;
use Illuminate\Support\Arr;

class LoanScheduleService
{
    protected LoanScheduleInterface $loanSchedule;

    public function __construct(LoanScheduleInterface $loanSchedule){
        $this->loanSchedule = $loanSchedule;
    }

    /**
     * Create a loan schedule for payment
     *
     * @param int $tenure
     * @param array $payload
     * @return bool
     */
    public function scheduleLoan(int $tenure, array $payload): bool
    {
        $createSchedule = [];
        for ($i=0; $i<$tenure; $i++) {
            $createSchedule[] = [
                'loan_application_id' => Arr::get($payload, 'loan_application_id'),
                'principal_balance' => Arr::get($payload, 'principal_balance'),
                'interest' => Arr::get($payload, 'interest'),
                'due_date' => Arr::get($payload, 'due_date')->addWeeks($i+1)->toDateString(),
                "created_at" => now(),
                "updated_at" => now(),
            ];
        }
        return $this->loanSchedule->insert($createSchedule);
    }


    /**
     * Remit loan by a user
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function remitLoan(array $attributes)
    {
        $loanSchedule = $this->loanSchedule->newQuery()
            ->where('loan_application_id', Arr::get($attributes, 'loan_application_id'))
            ->where('is_closed', false)
            ->first();

        if (empty($loanSchedule)) {
            abort(404, "Loan does not exist, all pending loans have been paid");
        }

        if ((float) $loanSchedule->principal_balance > (float) Arr::get($attributes, 'amount')) {
            abort(400, 'Insufficient amount to repay loan');
        }

        // update the loan schedule
        return $this->loanSchedule->update($loanSchedule->id, ['is_closed' => true]);
    }
}
