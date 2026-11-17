<?php

namespace App\Http\Requests\Interaction;

use Illuminate\Foundation\Http\FormRequest;

class IndexInteractionRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'drug_ids' => ['sometimes', 'required', 'array', 'min:1'],
            'drug_ids.*' => ['required', 'integer', 'distinct', 'exists:drugs,id'],
        ];
    }

}