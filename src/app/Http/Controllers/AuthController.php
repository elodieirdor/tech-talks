<?php

namespace App\Http\Controllers;

use App\Factory\Response\AuthResponseFactory;
use App\Factory\Model\UserFactory;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/user/register",
     *     tags={"user"},
     *     summary="Register an user in the app",
     *     operationId="register",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreUserRequest")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AuthResponse")
     *     ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *     ),
     *)
     **/
    public function register(StoreUserRequest $request, UserFactory $userFactory, AuthResponseFactory $authResponseFactory)
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
