<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\StatusOfPreviousComment;

class StatusOfPreviousCommentTest extends \PHPUnit_Framework_TestCase
{
    protected $increase = 1;
    protected $decrease = 1;
    protected $flag = 'spam';
    protected $off = -1;

    public function testSetScore()
    {
        $currentCommentEmail     = 'test';
        $prevCommentEmail        = 'test';
        $prevCommentFlag         = $this->flag;
        $statusOfPreviousComment = new StatusOfPreviousComment(
          $this->off, $this->decrease, $currentCommentEmail, $prevCommentEmail, $this->flag, $prevCommentFlag
        );
        $expected                = 0;
        $statusOfPreviousComment->setScore();
        $result  = $statusOfPreviousComment->getScore();
        $message = 'Should return 0; filter is off.';
        $this->assertEquals($expected, $result, $message);

        $currentCommentEmail     = 'test';
        $prevCommentEmail        = 'test';
        $prevCommentFlag         = $this->flag;
        $statusOfPreviousComment = new StatusOfPreviousComment(
          $this->increase, $this->decrease, $currentCommentEmail, $prevCommentEmail, $this->flag, $prevCommentFlag
        );
        $expected                = $this->increase;
        $statusOfPreviousComment->setScore();
        $result  = $statusOfPreviousComment->getScore();
        $message = 'Should return Increase since flags match';
        $this->assertEquals($expected, $result, $message);

        $currentCommentEmail     = 'test';
        $prevCommentEmail        = 'noMatch';
        $prevCommentFlag         = $this->flag;
        $statusOfPreviousComment = new StatusOfPreviousComment(
          $this->increase, $this->decrease, $currentCommentEmail, $prevCommentEmail, $this->flag, $prevCommentFlag
        );
        $expected                = 0;
        $statusOfPreviousComment->setScore();
        $result  = $statusOfPreviousComment->getScore();
        $message = 'Should return 0 since emails dont match';
        $this->assertEquals($expected, $result, $message);

        $currentCommentEmail     = 'test';
        $prevCommentEmail        = 'test';
        $prevCommentFlag         = 'no match';
        $statusOfPreviousComment = new StatusOfPreviousComment(
          $this->increase, $this->decrease, $currentCommentEmail, $prevCommentEmail, $this->flag, $prevCommentFlag
        );
        $expected                = -$this->decrease;
        $statusOfPreviousComment->setScore();
        $result  = $statusOfPreviousComment->getScore();
        $message = 'Should return decrease since flags dont match';
        $this->assertEquals($expected, $result, $message);

        $this->assertInstanceOf('\CmdZ\SpamCanner\Filters\FilterInterface', $statusOfPreviousComment);
    }
}
