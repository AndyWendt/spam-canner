<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\BodyInPreviousComment;

class BodyInPreviousCommentTest extends \PHPUnit_Framework_TestCase
{
    protected $filterClass = '\CmdZ\SpamCanner\Filters\BodyInPreviousComment';
    protected $interface = '\CmdZ\SpamCanner\Filters\FilterInterface';
    protected $increase = 1;
    protected $off = -1;

    public function testImplementsInterface()
    {
        $implementingClass = \Mockery::mock($this->filterClass);
        $this->assertInstanceOf($this->interface, $implementingClass);
    }

    public function testFilterIsOff()
    {
        $currentCommentBody = 'abcd';
        $prevCommentBody = 'abcd';
        $bodyInPrevious = new BodyInPreviousComment($this->off, $currentCommentBody, $prevCommentBody);
        $bodyInPrevious->setScore();

        $expected = 0;
        $message = 'Should return 0; filter is off.';
        $result = $bodyInPrevious->getScore();
        $this->assertEquals($expected, $result, $message);
    }

    public function testNoInfluenceSpamScore()
    {
        $currentCommentBody = 'zywx';
        $prevCommentBody = 'abcd';
        $bodyInPrevious = new BodyInPreviousComment($this->increase, $currentCommentBody, $prevCommentBody);
        $bodyInPrevious->setScore();

        $expected = 0;
        $message = 'Should return 0 because the bodys are not equal';
        $result = $bodyInPrevious->getScore();
        $this->assertEquals($expected, $result, $message);
    }

    public function testIncreaseSpamScore()
    {
        $currentCommentBody = 'abcd';
        $prevCommentBody = 'abcd';
        $bodyInPrevious = new BodyInPreviousComment($this->increase, $currentCommentBody, $prevCommentBody);
        $bodyInPrevious->setScore();

        $expected = $this->increase;
        $result = $bodyInPrevious->getScore();
        $message = 'Should return $increase';
        $this->assertEquals($expected, $result, $message);
    }
}
