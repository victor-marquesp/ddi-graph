<?php

namespace App\Http\Requests\Interaction;

use App\Enums\Severity;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInteractionRequest extends FormRequest {
    
    public function authorize() : bool {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules() : array {

        return [
            'severity' => ['required', Rule::enum(Severity::class)],
            'description' => ['nullable', 'string', 'max:65535']
        ];

    }
}
