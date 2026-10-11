<?php

namespace App\Http\Requests\Graph;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SelectedGraphRequest extends FormRequest {
    
    public function authorize() : bool {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules() : array {
        
        return [
            'drug_ids' => ['required', 'array', 'min:1'],
            'drug_ids.*' => ['required', 'integer', 'distinct', 'exists:drugs,id'],
        ];

    }
}
