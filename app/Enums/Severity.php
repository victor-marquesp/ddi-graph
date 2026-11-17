<?php

namespace App\Enums;

enum Severity : string {

    case CONTRAINDICATED = 'contraindicated';
    case MAJOR = 'major';
    case MODERATE = 'moderate';
    case MINOR = 'minor';
    
    public function weight() : int {

        return match ($this) {
            self::MINOR => 1,
            self::MODERATE => 2,
            self::MAJOR => 3,
            self::CONTRAINDICATED => 4,
        };
        
    }
    
}
