<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanScheduleRequest;
use App\Services\LoanScheduleService;
use Illuminate\Http\Request;

class LoanScheduleController extends Controller
{
    protected $loanSchedule;

    public function __construct()
    {
        $this->loanSchedule = resolve(LoanScheduleService::class);
    }


    public function create(LoanScheduleRequest $request)
    {
        $remit = $this->loanSchedule->remitLoan($request->validated());
        return $this->successResponse("Loan remittance successful", $remit);
    }
}
