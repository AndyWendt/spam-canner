<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\FirstWord;

class FirstWordTest extends \PHPUnit_Framework_TestCase
{
    protected $firstWords = ['Interesting', 'cool', 'sorry', 'nice'];
    protected $increase = 10;
    protected $off = -1;

    public function testSetScore()
    {
        $text      = 'cool beans';
        $firstWord = new FirstWord($this->firstWords, $this->off, $text);
        $expected  = 0;
        $firstWord->setScore();
        $result  = $firstWord->getScore();
        $message = 'Should return 0; filter is off.';
        $this->assertEquals($expected, $result, $message);

        $text      = 'cool beans';
        $firstWord = new FirstWord($this->firstWords, $this->increase, $text);
        $expected  = $this->increase;
        $firstWord->setScore();
        $result  = $firstWord->getScore();
        $message = 'Should return $increase';
        $this->assertEquals($expected, $result, $message);

        $text      = 'asd;lf as;lfd a;sldf';
        $firstWord = new FirstWord($this->firstWords, $this->increase, $text);
        $expected  = 0;
        $firstWord->setScore();
        $result  = $firstWord->getScore();
        $message = 'Should return 0';
        $this->assertEquals($expected, $result, $message);

        $this->assertInstanceOf('\CmdZ\SpamCanner\Filters\FilterInterface', $firstWord);
    }
}
