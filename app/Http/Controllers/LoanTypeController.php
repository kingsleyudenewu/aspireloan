<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanTypeRequest;
use App\Http\Resources\LoanTypeResource;
use App\Services\LoanTypeService;
use Illuminate\Http\Request;

class LoanTypeController extends Controller
{

    protected LoanTypeService $loanTypesService;

    public function __construct()
    {
        $this->loanTypesService = resolve(LoanTypeService::class);
    }

    /**
     * Fetch all the available loan types
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $loanTypes = $this->loanTypesService->getLoanTypes();
        return $this->successResponse('Loan Types retrieved successfully', $loanTypes->data);
    }

    /**
     * Create a loan type
     *
     * @param LoanTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(LoanTypeRequest $request): \Illuminate\Http\JsonResponse
    {
        $loanType = $this->loanTypesService->createLoanType($request->validated());
        return $this->createdResponse("Loan type created successfully", $loanType);
    }
}
