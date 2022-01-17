<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function loanApplication(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LoanApplication::class);
    }
}
