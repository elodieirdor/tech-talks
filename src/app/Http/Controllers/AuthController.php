<?php

namespace App\Http\Controllers;

use App\Factory\Response\AuthResponseFactory;
use App\Factory\Model\UserFactory;
use App\Http\Requests\StoreUser;

class AuthController extends Controller
{
    public function register(StoreUser $request, UserFactory $userFactory, AuthResponseFactory $authResponseFactory)
    {
        $user = $userFactory->createFromRequest($request);
        $authResponse = $authResponseFactory->createFromUser($user);

        return response()->json($authResponse->toArray(), 200);
    }
}
