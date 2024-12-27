<?php

namespace App\Http\Requests\Distribution;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class DistributeMoneyInvestmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|integer|min:1',
            'rates' => 'required|array',
            'rates.*' => 'required|numeric|min:0|max:1',
        ];
    }

    /**
     * Perform custom validation after default rules have passed.
     *
     * @param Validator $validator
     * @return void
     */
    protected function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $rates = $this->input('rates', []);
            $totalRate = array_sum($rates);

            if ($totalRate != 1) {
                $validator->errors()->add('rates', 'The total sum of the investment rates must be equal to 1.');
            }
        });
    }
}
