<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\StatusOfPreviousComment;

class StatusOfPreviousCommentTest extends \PHPUnit_Framework_TestCase
{
    protected $interface = '\CmdZ\SpamCanner\Filters\FilterInterface';
    protected $filterClass = '\CmdZ\SpamCanner\Filters\StatusOfPreviousComment';
    protected $increase = 1;
    protected $decrease = 1;
    protected $flag = 'spam';
    protected $off = -1;

    public function testImplementsInterface()
    {
        $mockedFilterClass = \Mockery::mock($this->filterClass);
        $this->assertInstanceOf($this->interface, $mockedFilterClass);
    }

    public function testFilterIsOff()
    {
        $currentCommentEmail = 'test';
        $prevCommentEmail = 'test';
        $prevCommentFlag = $this->flag;
        $statusOfPreviousComment = new StatusOfPreviousComment(
            $this->off, $this->decrease, $currentCommentEmail, $prevCommentEmail, $this->flag, $prevCommentFlag
        );
        $expected = 0;
        $statusOfPreviousComment->setScore();
        $result = $statusOfPreviousComment->getScore();
        $message = 'Should return 0; filter is off.';
        $this->assertEquals($expected, $result, $message);
    }

    public function testIncreaseSpamScore()
    {
        $currentCommentEmail = 'test';
        $prevCommentEmail = 'test';
        $prevCommentFlag = $this->flag;
        $statusOfPreviousComment = new StatusOfPreviousComment(
            $this->increase, $this->decrease, $currentCommentEmail, $prevCommentEmail, $this->flag, $prevCommentFlag
        );
        $expected = $this->increase;
        $statusOfPreviousComment->setScore();
        $result = $statusOfPreviousComment->getScore();
        $message = 'Should return Increase since flags match';
        $this->assertEquals($expected, $result, $message);
    }

    public function testDecreaseSpamScore()
    {
        $currentCommentEmail = 'test';
        $prevCommentEmail = 'test';
        $prevCommentFlag = 'no match';
        $statusOfPreviousComment = new StatusOfPreviousComment(
            $this->increase, $this->decrease, $currentCommentEmail, $prevCommentEmail, $this->flag, $prevCommentFlag
        );
        $expected = -$this->decrease;
        $statusOfPreviousComment->setScore();
        $result = $statusOfPreviousComment->getScore();
        $message = 'Should return decrease since flags dont match';
        $this->assertEquals($expected, $result, $message);
    }

    public function testNoInfluenceSpamScore()
    {
        $currentCommentEmail = 'test';
        $prevCommentEmail = 'noMatch';
        $prevCommentFlag = $this->flag;
        $statusOfPreviousComment = new StatusOfPreviousComment(
            $this->increase, $this->decrease, $currentCommentEmail, $prevCommentEmail, $this->flag, $prevCommentFlag
        );
        $expected = 0;
        $statusOfPreviousComment->setScore();
        $result = $statusOfPreviousComment->getScore();
        $message = 'Should return 0 since emails dont match';
        $this->assertEquals($expected, $result, $message);
    }
}
