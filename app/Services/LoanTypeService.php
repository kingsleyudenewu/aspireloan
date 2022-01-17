<?php

namespace App\Services;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\LoanTypeInterface;
use App\Models\LoanType;
use App\Repository\BaseRepository;
use App\Traits\ApiResponse;

class LoanTypeService
{
    use ApiResponse;

    protected LoanTypeInterface $loanTypeRepository;

    public function __construct(LoanTypeInterface $loanTypeRepository){
        $this->loanTypeRepository = $loanTypeRepository;
    }

    /**
     * @return array|\Illuminate\Support\Fluent|object
     */
    public function getLoanTypes()
    {
        return $this->ok($this->loanTypeRepository->all());
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getLoanType(int $id)
    {
        return $this->loanTypeRepository->find($id);
    }

    /**
     * @param array $attribute
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createLoanType(array $attribute): \Illuminate\Database\Eloquent\Model
    {
        return $this->loanTypeRepository->create($attribute);
    }

}
