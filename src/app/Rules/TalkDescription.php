<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TalkDescription implements Rule
{
    const MAX_NB_WORDS = 120;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return str_word_count($value) <= self::MAX_NB_WORDS;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return sprintf('The :attribute is too long : %d words limit', self::MAX_NB_WORDS);
    }
}
