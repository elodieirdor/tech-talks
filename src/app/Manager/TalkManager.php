<?php

namespace App\Manager;

use App\Talk;
use Symfony\Component\HttpFoundation\Request;

class TalkManager
{
    public function updateTalkFromRequest(Talk $talk, Request $request): bool
    {
        $data = [
            'topic' => $request->topic,
            'description' => $request->description,
            'date' => $request->date,
        ];

        return $talk->fill($data)->save();
    }

    public function publish(Talk $talk): bool
    {
        return $talk->fill(['status' => Talk::STATUS_PUBLISHED])->save();
    }
}
