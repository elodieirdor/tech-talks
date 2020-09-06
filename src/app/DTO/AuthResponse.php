<?php


namespace App\DTO;

use App\User;

/**
 * @OA\Schema(
 *     title="AuthResponse",
 *     description="Response to authenticate an user",
 *     type="object"
 * )
 */
class AuthResponse
{
    /**
     * @OA\Property(
     *     title="user",
     *     description="Name of the user",
     *     type="object",
     *     ref="#/components/schemas/User"
     * )
     *
     * @var User
     */
    protected User $user;

    /**
     * @OA\Property(
     *     title="token",
     *     description="Authentication token for user",
     *     type="string"
     * )
     *
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
