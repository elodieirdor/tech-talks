<?php


namespace App\Factory\Response;


use App\DTO\AuthResponse;
use App\User;

class AuthResponseFactory
{
    const TOKEN_NAME = 'AuthFrontApp';

    public function createFromUser(User  $user) : AuthResponse
    {
        $token = $user->createToken(self::TOKEN_NAME)->accessToken;
        $authResponse = new AuthResponse($user, $token);

        return $authResponse;
    }
}
