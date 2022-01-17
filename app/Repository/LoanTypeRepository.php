<?php

namespace App\Repository;

use App\Contracts\LoanTypeInterface;
use App\Models\LoanType;
use Illuminate\Database\Eloquent\Model;

class LoanTypeRepository extends BaseRepository implements LoanTypeInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * RateVariationRepositoryImpl constructor.
     *
     * @param LoanType $model
     */
    public function __construct(LoanType $model)
    {
        parent::__construct($model);
    }
}
