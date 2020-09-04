<?php

namespace App\Repository;

use App\Talk;
use DateTime;

class TalkRepository extends BaseRepository
{
    public function __construct(Talk $model)
    {
        parent::__construct($model);
    }

    public function getUpcoming(\DateTime $talkDate)
    {
        // TODO : remove dateTime : inject it
        $from = (new \DateTime())->setTime(0,0);

        return Talk::where('status', Talk::STATUS_PUBLISHED)
            ->whereBetween('date', [$from, $talkDate])
            ->get();
    }
}
