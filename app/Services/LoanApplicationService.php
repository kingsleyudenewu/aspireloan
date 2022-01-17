<?php

namespace App\Services;

use App\Contracts\LoanApplicationInterface;
use App\Models\LoanApplication;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class LoanApplicationService
{
    protected LoanApplicationInterface $loanApplication;

    public function __construct(LoanApplicationInterface $loanApplication){
        $this->loanApplication = $loanApplication;
    }

    /**
     * Fetch all loans belonging to a user
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function fetchUserLoan(string $status = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->loanApplication->newQuery()
            ->where('user_id', auth()->user()->id)
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            }, function ($query) {
                return $query->orderBy('status', LoanApplication::PENDING)
                    ->orderByRaw(DB::raw("FIELD(status, '".LoanApplication::PENDING."',
            '".LoanApplication::APPROVED."', '".LoanApplication::REJECTED."')"));
            })
            ->paginate();
    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function applyForLoan(array $attributes): \Illuminate\Database\Eloquent\Model
    {
        $loanType = resolve(LoanTypeService::class)->getLoanType((int) Arr::get($attributes, 'loan_type_id'));
        $principal = Arr::get($attributes, 'principal');
        $tenure = Arr::get($attributes, 'tenure');
        $principalInterest = ($loanType->interest / 100) * $principal;
        $totalAmount = $principal + $principalInterest;

        return $this->loanApplication->create([
            'user_id' => auth()->user()->id,
            'loan_type_id' => $loanType->id,
            'principal' => $principal,
            'total_amount' => $totalAmount,
            'tenure' => $tenure,
            'status' => LoanApplication::PENDING
        ]);
    }

    /**
     * Approve pending loan for a user
     *
     * @param int $loanApplicationId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function approveLoan(int $loanApplicationId): \Illuminate\Database\Eloquent\Model
    {
        // Approve the loan application
        $payload = [
            'approved_date' => now()->toDateString(),
            'status' => LoanApplication::APPROVED
        ];
        $updateLoan = $this->loanApplication->update($loanApplicationId, $payload);
        $totalAmount = floatval($updateLoan->total_amount / $updateLoan->tenure);

        //create a loan schedule
        $data = [
            'loan_application_id' => $updateLoan->id,
            'interest' => $updateLoan->loanType->interest,
            'due_date' => $updateLoan->approved_date,
            'principal_balance' => $totalAmount
        ];
        resolve(LoanScheduleService::class)->scheduleLoan((int) $updateLoan->tenure, $data);
        return $updateLoan->load('loanSchedule');
    }

    /**
     * Get the loan
     *
     * @param int $id
     * @return mixed
     */
    public function getLoanApplicationById(int $id)
    {
        return $this->loanApplication->find($id);
    }

    /**
     * This will find a loan application for a specific user
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getLoanApplicatinByUser(int $id)
    {
        return $this->loanApplication->newQuery()
            ->with(['loanType', 'loanSchedule'])
            ->where('user_id', auth()->user()->id)
            ->find($id);
    }
}
