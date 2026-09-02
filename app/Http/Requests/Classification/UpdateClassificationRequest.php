<?php

namespace App\Http\Requests\Classification;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClassificationRequest extends FormRequest {
    
    public function authorize() : bool {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules() : array {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:classifications,name,'.$this->classification->id],
            'description' => ['nullable', 'string', 'max:65535']
        ];
    }
}
