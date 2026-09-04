<?php

namespace App\Enums;

enum Severity : string {

    case CONTRAINDICATED = 'contraindicated';
    case MAJOR = 'major';
    case MODERATE = 'moderate';
    case MINOR = 'minor';
    
}
