<?php


namespace App\DTO\Virtual\Request;

/**
 * @OA\Schema(
 *     title="Log User request",
 *     description="Log User request body data",
 *     type="object",
 *     required={"email", "password"}
 * )
 */
class LogUserRequest
{
    /**
     * @OA\Property(
     *     title="email",
     *     description="Email of the user",
     *     type="string",
     *     format="email",
     * )
     *
     * @var string
     */
    public string $email;

    /**
     * @OA\Property(
     *     title="password",
     *     description="Password of the user",
     *     type="string",
     * )
     *
     * @var string
     */
    public string $password;
}
