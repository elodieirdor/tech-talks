<?php


namespace App\DTO;

use App\User;

class AuthResponse
{
    /**
     * @var User
     */
    protected User $user;

    /**
     * @var string
     */
    protected string $token;

    /**
     * AuthResponse constructor.
     * @param User $user
     * @param string $token
     */
    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function toArray() : array
    {
        return [
            'token' => $this->token,
            'user' => $this->user->toArray(),
        ];
    }
}
