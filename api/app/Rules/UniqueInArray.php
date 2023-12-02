<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueInArray implements ValidationRule
{

    private $ary;
    private $errorMessage;

    public function __construct($ary, $errorMessage)
    {
        $this->ary          = $ary;
        $this->errorMessage = $errorMessage;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (in_array($value, $this->ary)) {
            $fail($this->errorMessage);
        }
    }
}
