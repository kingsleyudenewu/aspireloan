<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveLoanRequest;
use App\Http\Requests\LoanApplicationRequest;
use App\Models\LoanApplication;
use App\Services\LoanApplicationService;
use Illuminate\Http\Request;

class LoanApplicationController extends Controller
{
    protected LoanApplicationService $loanApplicationService;

    public function __construct()
    {
        $this->loanApplicationService = resolve(LoanApplicationService::class);
    }

    /**
     * Fetch all loan applications belonging to a user
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $loans = $this->loanApplicationService->fetchUserLoan($request->status);
        return $this->successResponse('Loan application retrieved successfully', $loans);
    }

    /**
     * Fetch al the schedules associated to a loan application
     *
     * @param LoanApplication $loanApplication
     * @return \Illuminate\Http\JsonResponse
     */
    public function loanSchedule(LoanApplication $loanApplication): \Illuminate\Http\JsonResponse
    {
        $schedules = $this->loanApplicationService->getLoanApplicationByUser($loanApplication->id);
        if (empty($schedules)) {
            return $this->notFoundResponse("Loan application not available");
        }
        return $this->successResponse('Loan application retrieved successfully', $schedules);
    }

    /**
     * This is to create a loan application by a user
     *
     * @param LoanApplicationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(LoanApplicationRequest $request): \Illuminate\Http\JsonResponse
    {
        $loan = $this->loanApplicationService->applyForLoan($request->validated());
        return $this->createdResponse("Loan application submitted", $loan->data);
    }

    /**
     * This is to approve a loan request for a user
     *
     * @param ApproveLoanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function approve(ApproveLoanRequest $request): \Illuminate\Http\JsonResponse
    {
        $approveLoan = $this->loanApplicationService->approveLoan((int)$request->loan_application_id);
        return $this->successResponse("Loan approval successful", $approveLoan);
    }
}
