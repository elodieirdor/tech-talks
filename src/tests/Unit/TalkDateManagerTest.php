<?php

namespace Tests\Unit;

use App\Manager\TalkDateManager;
use PHPUnit\Framework\TestCase;

class TalkDateManagerTest extends TestCase
{
    public function testGetNextTalkDateOddMonth()
    {
        $talkDateManager = new TalkDateManager();
        $nextDate = $talkDateManager->getNextTalkDate(new \DateTime('2020-01-01'));
        $expected = new \DateTime('2020-02-05');
        $this->assertEquals($nextDate, $expected);
    }

    public function testGetNextTalkDateEvenMonthBeginning()
    {
        $talkDateManager = new TalkDateManager();
        $nextDate = $talkDateManager->getNextTalkDate(new \DateTime('2020-02-02'));
        $expected = new \DateTime('2020-02-05');
        $this->assertEquals($nextDate, $expected);
    }

    public function testGetNextTalkDateEvenMonthLast()
    {
        $talkDateManager = new TalkDateManager();
        $nextDate = $talkDateManager->getNextTalkDate(new \DateTime('2020-02-10'));
        $expected = new \DateTime('2020-04-01');
        $this->assertEquals($nextDate, $expected);
    }

    public function testGetNextTalkDateEvenMonthEndYear()
    {
        $talkDateManager = new TalkDateManager();
        $nextDate = $talkDateManager->getNextTalkDate(new \DateTime('2020-12-04'));
        $expected = new \DateTime('2021-02-03');
        $this->assertEquals($nextDate, $expected);
    }

    public function testisSubmissionDateValidWithOddMonth()
    {
        $talkDateManager = new TalkDateManager();
        $submissionDate = new \DateTime('2020-01-01');
        $currentDate = new \DateTime('2019-12-31');
        $this->assertFalse($talkDateManager->isSubmissionDateValid($submissionDate, $currentDate));
    }

    public function testisSubmissionDateValidWithPastDate()
    {
        $talkDateManager = new TalkDateManager();
        $submissionDate = new \DateTime('2019-12-03');
        $currentDate = new \DateTime('2019-12-31');
        $this->assertFalse($talkDateManager->isSubmissionDateValid($submissionDate, $currentDate));
    }

    public function testisSubmissionDateValidWithMonthLimit()
    {
        $talkDateManager = new TalkDateManager();
        $submissionDate = new \DateTime('2020-08-04');
        $currentDate = new \DateTime('2019-12-31');
        $this->assertFalse($talkDateManager->isSubmissionDateValid($submissionDate, $currentDate));
    }

    public function testisSubmissionDateValidWithEvenMonthAndWrongDay()
    {
        $talkDateManager = new TalkDateManager();
        $submissionDate = new \DateTime('2020-02-06');
        $currentDate = new \DateTime('2019-12-31');
        $this->assertFalse($talkDateManager->isSubmissionDateValid($submissionDate, $currentDate));
    }

    public function testisSubmissionDateValidWithCorrectDate()
    {
        $talkDateManager = new TalkDateManager();
        $submissionDate = new \DateTime('2020-02-04');
        $currentDate = new \DateTime('2019-12-31');
        $this->assertTrue($talkDateManager->isSubmissionDateValid($submissionDate, $currentDate));
    }

    public function testisSubmissionDateValidWithDateInCurrentMonth()
    {
        $talkDateManager = new TalkDateManager();
        $submissionDate = new \DateTime('2020-10-06');
        $currentDate = new \DateTime('2020-10-05');
        $this->assertTrue($talkDateManager->isSubmissionDateValid($submissionDate, $currentDate));
    }
}
