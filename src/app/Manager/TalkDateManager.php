<?php

namespace App\Manager;

class TalkDateManager
{
    const TALK_DAY = 'wednesday';
    const SUBMISSION_TALK_DAY = 'tuesday';

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

        $d = clone $date;

        if ($month % 2 === 0) {
            // get first wednesday of the month
            // ie : first wednesday 2020-12
            $str = sprintf("first %s of %s %d", self::TALK_DAY, $date->format('F'), $date->format('Y'), );
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

    /**
     * @param \DateTime $submissionDate
     * @param \DateTime|null $currentDate
     * @return bool
     */
    public function isSubmissionDateValid(\DateTime $submissionDate, \DateTime $currentDate = null) : bool
    {
        $currentDate = $currentDate ?? new \DateTime();
        $currentDate->setTime(0,0);

        if ($submissionDate < $currentDate) {
            return false;
        }

        $maxDate = clone $currentDate;
        $maxDate->modify('+6 months');
        if ($submissionDate > $maxDate) {
            return false;
        }

        $month = $submissionDate->format('m');
        if ($month % 2 !== 0) {
            return false;
        }

        $str = sprintf("first %s of %s %d", self::SUBMISSION_TALK_DAY, $submissionDate->format('F'), $submissionDate->format('Y'), );
        $submissionDayOfMonth = (new \DateTime())->setTimestamp(strtotime($str))->setTime(0, 0);
        if ($submissionDate != $submissionDayOfMonth) {
            return false;
        }

        return true;
    }
}
