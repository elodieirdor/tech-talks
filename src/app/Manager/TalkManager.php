<?php

namespace App\Manager;

class TalkManager
{
    const TALK_DAY = 'wednesday';

    /**
     * The talks are run on the first Wednesday of every even month
     *
     * @param \DateTime $date
     * @return \DateTime
     */
    public function getNextTalkDate(\DateTime $date): \DateTime
    {
        $talkDay = self::TALK_DAY;
        $month = $date->format('m');
        $year = $date->format('Y');

        $d = clone $date;

        if ($month % 2 === 0) {
            // get first wednesday of the month
            // ie : first wednesday 2020-12
            $str = "first $talkDay $year-$month";
            $talkOfMonth = (new \DateTime())->setTimestamp(strtotime($str))->setTime(0, 0);

            if ($date < $talkOfMonth) {
                return $talkOfMonth;
            }

            // trick to handle this current month as an odd month
            $d->modify("next month");
        }

        $d->modify("first $talkDay of next month");

        return $d;
    }
}
