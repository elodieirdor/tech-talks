<?php

namespace App\Rules;

use App\Manager\TalkManager;
use Illuminate\Contracts\Validation\Rule;

class TalkDate implements Rule
{
    protected TalkManager $talkManager;

    /**
     * Create a new rule instance.
     */
    public function __construct()
    {
        $this->talkManager = resolve(TalkManager::class);
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
        $date = new \DateTime($value);

        return $this->talkManager->isSubmissionDateValid($date);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute does not match the rules.';
    }
}
