<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxImages implements Rule
{
    public function passes($attribute, $value)
    {
        $count = is_array($value) ? count($value) : 0;

        return $count <= 5;
    }

    public function message()
    {
        return 'The number of images cannot exceed 5.';
    }
}
