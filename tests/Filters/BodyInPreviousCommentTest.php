<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\BodyInPreviousComment;

class BodyInPreviousCommentTest extends \PHPUnit_Framework_TestCase
{
    protected $increase = 1;
    protected $off = -1;

    public function testSetScore()
    {
        $currentCommentBody = 'abcd';
        $prevCommentBody    = 'abcd';
        $bodyInPrevious     = new BodyInPreviousComment($this->off, $currentCommentBody, $prevCommentBody);
        $bodyInPrevious->setScore();
        $expected = 0;
        $result   = $bodyInPrevious->getScore();
        $message  = 'Should return 0; filter is off.';
        $this->assertEquals($expected, $result, $message);

        $currentCommentBody = 'zywx';
        $prevCommentBody    = 'abcd';
        $bodyInPrevious     = new BodyInPreviousComment($this->increase, $currentCommentBody, $prevCommentBody);
        $bodyInPrevious->setScore();
        $expected = 0;
        $result   = $bodyInPrevious->getScore();
        $message  = 'Should return 0 because the bodys are not equal';
        $this->assertEquals($expected, $result, $message);

        $currentCommentBody = 'abcd';
        $prevCommentBody    = 'abcd';
        $bodyInPrevious     = new BodyInPreviousComment($this->increase, $currentCommentBody, $prevCommentBody);
        $expected           = $this->increase;
        $bodyInPrevious->setScore();
        $result  = $bodyInPrevious->getScore();
        $message = 'Should return $increase';
        $this->assertEquals($expected, $result, $message);

        $this->assertInstanceOf('\CmdZ\SpamCanner\Filters\FilterInterface', $bodyInPrevious);
    }
}
