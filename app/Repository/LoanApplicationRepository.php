<?php

namespace App\Repository;

use App\Contracts\LoanApplicationInterface;
use App\Models\LoanApplication;
use App\Models\LoanType;
use Illuminate\Database\Eloquent\Model;

class LoanApplicationRepository extends BaseRepository implements LoanApplicationInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * RateVariationRepositoryImpl constructor.
     *
     * @param LoanApplication $model
     */
    public function __construct(LoanApplication $model)
    {
        parent::__construct($model);
    }
}
