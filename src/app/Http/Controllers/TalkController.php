<?php

namespace App\Http\Controllers;

use App\Factory\Model\TalkFactory;
use App\Http\Requests\StoreTalk;
use App\Manager\TalkManager;
use App\Repository\TalkRepository;

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

    public function upcoming(TalkManager $talkManager)
    {
        $date = $talkManager->getNextTalkDate(new \DateTime());
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

    public function createTalk(StoreTalk $request, TalkFactory $talkFactory)
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
}
