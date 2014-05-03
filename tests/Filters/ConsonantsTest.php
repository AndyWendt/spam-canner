<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\Consonants;

class ConsonantsTest extends \PHPUnit_Framework_TestCase
{
    protected $interface = '\CmdZ\SpamCanner\Filters\FilterInterface';
    protected $filterClass = 'CmdZ\SpamCanner\Filters\Consonants';
    protected $increase = 1;
    protected $off = -1;

    public function testImplementsInterface()
    {
        $filterClassMock = \Mockery::mock($this->filterClass);
        $this->assertInstanceOf($this->interface, $filterClassMock);
    }

    public function testFilterIsOff()
    {
        $text = 'bcdfgh';
        $consonants = new Consonants($this->off, $text);
        $expected = 0;
        $consonants->setScore();
        $result = $consonants->getScore();
        $message = 'Should return 0; filter is off.';
        $this->assertEquals($expected, $result, $message);
    }

    public function testIncreaseSpamScore()
    {
        $text = 'bcdfgbcdfgbcdfg bcdfg'; //four sets of 5 consonants
        $consonants = new Consonants($this->increase, $text);
        $expected = $this->increase * 4;
        $consonants->setScore();
        $result = $consonants->getScore();
        $message = 'Should return $increase * 4';
        $this->assertEquals($expected, $result, $message);
    }

    public function testNoInfluenceSpamScore()
    {
        $text = 'Lorem Ipsum Dolar Sit Tecum';
        $consonants = new Consonants($this->increase, $text);
        $expected = 0;
        $consonants->setScore();
        $result = $consonants->getScore();
        $message = 'Should return 0 since there are no matches';
        $this->assertEquals($expected, $result, $message);
    }
}
