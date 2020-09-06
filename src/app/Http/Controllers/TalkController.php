<?php

namespace App\Http\Controllers;

use App\Factory\Model\TalkFactory;
use App\Http\Requests\StoreTalk;
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
     *     tags={"talks"},
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
     *     tags={"talks"},
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
     *          @OA\MediaType(
     *              mediaType="application/json",
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

    public function create(StoreTalk $request, TalkFactory $talkFactory)
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
     *     tags={"talks"},
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
     *          @OA\MediaType(
     *              mediaType="application/json",
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

    public function edit(StoreTalk $request, int $id, TalkManager $talkManager)
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
