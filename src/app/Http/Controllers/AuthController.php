<?php

namespace App\Http\Controllers;

use App\Factory\Response\AuthResponseFactory;
use App\Factory\Model\UserFactory;
use App\Http\Requests\StoreUser;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(StoreUser $request, UserFactory $userFactory, AuthResponseFactory $authResponseFactory)
    {
        $user = $userFactory->createFromRequest($request);
        $authResponse = $authResponseFactory->createFromUser($user);

        return response()->json($authResponse->toArray(), 200);
    }

    public function login(Request $request, AuthResponseFactory $authResponseFactory)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $successAuth = auth()->attempt($data);

        if (false === $successAuth) {
            return response()->json(['error' => 'Unauthorised'], 401);
        }

        $authResponse = $authResponseFactory->createFromUser(auth()->user());

        return response()->json($authResponse->toArray(), 200);
    }
}
