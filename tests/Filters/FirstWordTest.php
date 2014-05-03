<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\FirstWord;

class FirstWordTest extends \PHPUnit_Framework_TestCase
{
    protected $interface = '\CmdZ\SpamCanner\Filters\FilterInterface';
    protected $filterClass = '\CmdZ\SpamCanner\Filters\FirstWord';
    protected $firstWords = ['Interesting', 'cool', 'sorry', 'nice'];
    protected $increase = 10;
    protected $off = -1;

    public function testImplementsInterface()
    {
        $mockedFilterClass = \Mockery::mock($this->filterClass);
        $this->assertInstanceOf($this->interface, $mockedFilterClass);
    }

    public function testFilterIsOff()
    {
        $text = 'cool beans';
        $firstWord = new FirstWord($this->off, $text, $this->firstWords);
        $expected = 0;
        $firstWord->setScore();
        $result = $firstWord->getScore();
        $message = 'Should return 0; filter is off.';
        $this->assertEquals($expected, $result, $message);
    }

    public function testIncreaseSpamScore()
    {
        $text = 'cool beans';
        $firstWord = new FirstWord($this->increase, $text, $this->firstWords);
        $expected = $this->increase;
        $firstWord->setScore();
        $result = $firstWord->getScore();
        $message = 'Should return $increase';
        $this->assertEquals($expected, $result, $message);
    }

    public function testNoInfluenceSpamScore()
    {
        $text = 'asd;lf as;lfd a;sldf';
        $firstWord = new FirstWord($this->increase, $text, $this->firstWords);
        $expected = 0;
        $firstWord->setScore();
        $result = $firstWord->getScore();
        $message = 'Should return 0';
        $this->assertEquals($expected, $result, $message);
    }
}
