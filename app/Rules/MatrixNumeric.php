<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Rule that checks that all items in a
 * matrix are numeric.
 */
class MatrixNumeric implements Rule
{
    /**
     * @inheritdoc
     */
    public function passes($attribute, $value): bool
    {
        foreach($value as $val) {
            $chk = array_filter($val, [$this, 'checkForNumber']);
            if(count($chk)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Checks if the param is an integer.
     *
     * @param mixed $value
     *
     * @return void|int
     */
    public function checkForNumber($value)
    {
        if (!(is_int($value))) {
            return $value;
        }
    }

    /**
     * @inheritdoc
     */
    public function message(): string
    {
        return "The :attribute must only contain integers(whole numbers).";
    }
}
