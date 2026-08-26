<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class LoginRequest extends FormRequest {

    public function authorize() : bool {

        return true;

    }

    #[Override]
    protected function prepareForValidation() : void {

        $this->merge([
            'remember' => $this->boolean('remember')
        ]);

    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
            'remember' => ['nullable', 'boolean']
        ];
    }

    public function credentials() : array {

        return $this->only('email', 'password');
    }

    public function remember() : bool {

        return $this->boolean('remember');
    }
}
