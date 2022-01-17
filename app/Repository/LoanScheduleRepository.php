<?php

namespace App\Repository;

use App\Contracts\LoanScheduleInterface;
use App\Models\LoanSchedule;
use Illuminate\Database\Eloquent\Model;

class LoanScheduleRepository extends BaseRepository implements LoanScheduleInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * RateVariationRepositoryImpl constructor.
     *
     * @param LoanSchedule $model
     */
    public function __construct(LoanSchedule $model)
    {
        parent::__construct($model);
    }
}
