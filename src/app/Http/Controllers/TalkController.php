<?php

namespace App\Http\Controllers;

use App\Factory\Model\TalkFactory;
use App\Http\Requests\StoreTalkRequest;
use App\Manager\TalkDateManager;
use App\Manager\TalkManager;
use App\Repository\TalkRepository;
use App\Talk;

class TalkController extends Controller
{
    /**
     * @var TalkRepository
     */
    private TalkRepository $talkRepository;

    public function __construct(TalkRepository $talkRepository)
    {
        $this->talkRepository = $talkRepository;
    }

    /**
     * @OA\Get(
     *     path="/talks/upcoming",
     *     tags={"talk"},
     *     summary="List upcoming talks",
     *     operationId="upcoming",
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Talk")
     *              )
     *          )
     *     ),
     *)
     **/
    public function upcoming(TalkDateManager $talkDateManager)
    {
        $date = $talkDateManager->getNextTalkDate(new \DateTime());
        $talks = $this->talkRepository->getUpcoming($date);

        return response()->json(
            [
                'success' => true,
                'data' => $talks
            ]
        );
    }

    /**
     * @OA\Get(
     *     path="/user/my-talks",
     *     tags={"talk"},
     *     summary="List user talks",
     *     operationId="userTalks",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Talk")
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorised",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              ),
     *          )
     *     ),
     *)
     **/
    public function userTalks()
    {
        $talks = auth()->user()->talks->sortBy('date')->values()->all();

        return response()->json(
            [
                'success' => true,
                'data' => $talks
            ]
        );
    }

    /**
     * @OA\Post(
     *     path="/talks",
     *     tags={"talk"},
     *     summary="Create a talk",
     *     operationId="create",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreTalkRequest")
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Talk"
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object"
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorised",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              ),
     *          )
     *     ),
     *)
     **/
    public function create(StoreTalkRequest $request, TalkFactory $talkFactory)
    {
        $talk = $talkFactory->createFromRequest($request, auth()->user());

        return response()->json(
            [
                'success' => true,
                'data' => $talk
            ],
            201
        );
    }

    /**
     * @OA\Get(
     *     path="/talks/{id}",
     *     tags={"talk"},
     *     summary="List a user talk",
     *     operationId="read",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/Talk"
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorised",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *              )
     *          )
     *     ),
     *)
     **/
    public function read(int $id)
    {
        /** @var Talk $talk */
        $talk = auth()->user()->talks->find($id);

        if (null === $talk) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'The talk does not exist'
                ],
                404
            );
        }

        return response()->json(
            [
                'success' => true,
                'data' => $talk
            ]
        );
    }

    /**
     * @OA\Post(
     *     path="/talks/{id}",
     *     tags={"talk"},
     *     summary="Edit a talk",
     *     operationId="edit",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreTalkRequest")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Talk updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Talk"
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object"
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorised",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Unauthorised",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              ),
     *          )
     *     ),
     *)
     **/
    public function edit(StoreTalkRequest $request, int $id, TalkManager $talkManager)
    {
        /** @var Talk $talk */
        $talk = auth()->user()->talks->find($id);
        $updated = $talkManager->updateTalkFromRequest($talk, $request);

        if (false === $updated) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'An error occurred while saving the talk'
                ],
                500
            );
        }

        return response()->json(
            [
                'success' => true,
                'data' => $talk
            ]
        );
    }

    /**
     * @OA\Put(
     *     path="/talks/{id}",
     *     tags={"talk"},
     *     summary="Publish a talk",
     *     operationId="publish",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Talk updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Talk"
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Talk not found",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorised",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Error publishing",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              ),
     *          )
     *     ),
     *)
     **/
    public function publish(int $id, TalkManager $talkManager)
    {
        /** @var Talk $talk */
        $talk = auth()->user()->talks->find($id);

        if (null === $talk) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'The talk does not exist'
                ],
                404
            );
        }

        $published = $talkManager->publish($talk);
        if (false === $published) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'An error occurred while publishing the talk'
                ],
                500
            );
        }

        return response()->json(
            [
                'success' => true,
                'data' => $talk
            ]
        );
    }
}
