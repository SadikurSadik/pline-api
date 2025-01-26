<?php

namespace App\Enums;

enum GradeName: int
{
    case GRADE_A = 1;
    case GRADE_B = 2;
    case GRADE_C = 3;
    case GRADE_D = 4;
    case GRADE_E = 5;

    public function getLabel(): string
    {
        return match ($this) {
            GradeName::GRADE_A => 'GRADE A',
            GradeName::GRADE_B => 'GRADE B',
            GradeName::GRADE_C => 'GRADE C',
            GradeName::GRADE_D => 'GRADE D',
            GradeName::GRADE_E => 'GRADE E',
        };
    }
}
