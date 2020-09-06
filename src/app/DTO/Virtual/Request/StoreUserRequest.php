<?php


namespace App\DTO\Request;

/**
 * @OA\Schema(
 *     title="Store User request",
 *     description="Store User request body data",
 *     type="object",
 *     required={"name", "email", "password"}
 * )
 */
class StoreUserRequest
{
    /**
     * @OA\Property(
     *     title="name",
     *     description="Name of the user",
     *     type="string",
     * )
     *
     * @var string
     */
    public string $name;

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
     *     description="Password of the user with at least one uppercase character, one lowercase character,
     * one number, one special char",
     *     type="string",
     *     minimum=8,
     *     maximum=20,
     * )
     *
     * @var string
     */
    public string $password;

}
