<?php

namespace App\Http\Requests\Interaction;

use App\Enums\Severity;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInteractionRequest extends FormRequest {
    
    public function authorize() : bool {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules() : array {
        return [
            'drugA_id' => ['required', 'exists:drugs,id'],
            'drugB_id' => ['required', 'exists:drugs,id'],              //  'different:drugA_id'
            'severity' => ['required', Rule::enum(Severity::class)],
            'description' => ['nullable', 'string', 'max:65535']
        ];

    }
}
