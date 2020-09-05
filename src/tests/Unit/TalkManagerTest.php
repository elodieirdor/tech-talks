<?php

namespace Tests\Unit;

use App\Manager\TalkManager;
use PHPUnit\Framework\TestCase;

class TalkManagerTest extends TestCase
{
    public function testGetNextTalkDateOddMonth()
    {
        $talkManager = new TalkManager();
        $nextDate = $talkManager->getNextTalkDate(new \DateTime('2020-01-01'));
        $expected = new \DateTime('2020-02-05');
        $this->assertEquals($nextDate, $expected);
    }

    public function testGetNextTalkDateEvenMonthBeginning()
    {
        $talkManager = new TalkManager();
        $nextDate = $talkManager->getNextTalkDate(new \DateTime('2020-02-02'));
        $expected = new \DateTime('2020-02-05');
        $this->assertEquals($nextDate, $expected);
    }

    public function testGetNextTalkDateEvenMonthLast()
    {
        $talkManager = new TalkManager();
        $nextDate = $talkManager->getNextTalkDate(new \DateTime('2020-02-10'));
        $expected = new \DateTime('2020-04-01');
        $this->assertEquals($nextDate, $expected);
    }

    public function testGetNextTalkDateEvenMonthEndYear()
    {
        $talkManager = new TalkManager();
        $nextDate = $talkManager->getNextTalkDate(new \DateTime('2020-12-04'));
        $expected = new \DateTime('2021-02-03');
        $this->assertEquals($nextDate, $expected);
    }

    public function testisSubmissionDateValidWithOddMonth()
    {
        $talkManager = new TalkManager();
        $submissionDate = new \DateTime('2020-01-01');
        $currentDate = new \DateTime('2019-12-31');
        $this->assertFalse($talkManager->isSubmissionDateValid($submissionDate, $currentDate));
    }

    public function testisSubmissionDateValidWithPastDate()
    {
        $talkManager = new TalkManager();
        $submissionDate = new \DateTime('2019-12-03');
        $currentDate = new \DateTime('2019-12-31');
        $this->assertFalse($talkManager->isSubmissionDateValid($submissionDate, $currentDate));
    }

    public function testisSubmissionDateValidWithMonthLimit()
    {
        $talkManager = new TalkManager();
        $submissionDate = new \DateTime('2020-08-04');
        $currentDate = new \DateTime('2019-12-31');
        $this->assertFalse($talkManager->isSubmissionDateValid($submissionDate, $currentDate));
    }

    public function testisSubmissionDateValidWithEvenMonthAndWrongDay()
    {
        $talkManager = new TalkManager();
        $submissionDate = new \DateTime('2020-02-06');
        $currentDate = new \DateTime('2019-12-31');
        $this->assertFalse($talkManager->isSubmissionDateValid($submissionDate, $currentDate));
    }

    public function testisSubmissionDateValidWithCorrectDate()
    {
        $talkManager = new TalkManager();
        $submissionDate = new \DateTime('2020-02-04');
        $currentDate = new \DateTime('2019-12-31');
        $this->assertTrue($talkManager->isSubmissionDateValid($submissionDate, $currentDate));
    }

    public function testisSubmissionDateValidWithDateInCurrentMonth()
    {
        $talkManager = new TalkManager();
        $submissionDate = new \DateTime('2020-10-06');
        $currentDate = new \DateTime('2020-10-05');
        $this->assertTrue($talkManager->isSubmissionDateValid($submissionDate, $currentDate));
    }
}
