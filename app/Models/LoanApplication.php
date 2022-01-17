<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    use HasFactory;

    const PENDING = 'pending';
    const REJECTED = 'rejected';
    const APPROVED = 'approved';

    protected $guarded = ['id'];

    protected $casts = [
        'approved_date' => 'date'
    ];

    public function loanType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(LoanType::class);
    }

    public function loanSchedule(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LoanSchedule::class);
    }
}
