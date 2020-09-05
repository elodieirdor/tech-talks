<?php

namespace App\Rules;

use App\Manager\TalkDateManager;
use Illuminate\Contracts\Validation\Rule;

class TalkDate implements Rule
{
    protected TalkDateManager $talkDateManager;

    /**
     * Create a new rule instance.
     */
    public function __construct()
    {
        $this->talkDateManager = resolve(TalkDateManager::class);
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

        return $this->talkDateManager->isSubmissionDateValid($date);
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
