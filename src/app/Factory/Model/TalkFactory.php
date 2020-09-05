<?php


namespace App\Factory\Model;

use App\Talk;
use App\User;
use Symfony\Component\HttpFoundation\Request;

class TalkFactory
{
    public function createFromRequest(Request  $request, User $user) : Talk
    {
        $talk = new Talk;
        $talk->topic = $request->topic;
        $talk->description = $request->description;
        $talk->date = $request->date;
        $talk->status = Talk::STATUS_DRAFT;

        $user->talks()->save($talk);

        return $talk;
    }
}
