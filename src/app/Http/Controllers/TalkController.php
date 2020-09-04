<?php

namespace App\Http\Controllers;

use App\Manager\TalkManager;
use App\Repository\TalkRepository;

class TalkController extends Controller
{
    private $talkRepository;

    public function __construct(TalkRepository $talkRepository)
    {
        $this->talkRepository = $talkRepository;
    }

    public function upcoming(TalkManager $talkManager)
    {
        $date = $talkManager->getNextTalkDate(new \DateTime());
        $talks = $this->talkRepository->getUpcoming($date);

        return $talks;
    }
}
