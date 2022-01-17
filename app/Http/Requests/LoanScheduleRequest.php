<?php

namespace App\Http\Requests;

use App\Models\LoanApplication;
use Illuminate\Foundation\Http\FormRequest;

class LoanScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'loan_application_id' => 'required|exists:loan_applications,id,status,'
                .LoanApplication::APPROVED.',user_id,'.auth()->user()->id,
            'amount' => 'required'
        ];
    }
}
