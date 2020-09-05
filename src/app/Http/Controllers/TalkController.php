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

    public function userTalks()
    {
        $talks = auth()->user()->talks;

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
}
