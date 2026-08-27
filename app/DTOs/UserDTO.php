<?php

namespace App\DTOs;

readonly class UserDTO {

    private function __construct(
        public string $name,
        public string $email,
        public string $password
    ){}

    public static function fromArray(array $data) : self {

        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password']
        );
    
    }

}