<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\Consonants;

class ConsonantsTest extends \PHPUnit_Framework_TestCase
{
    protected $increase = 1;
    protected $off = -1;

    public function testSetScore()
    {
        $text       = 'bcdfgh';
        $consonants = new Consonants($this->off, $text);
        $expected   = 0;
        $consonants->setScore();
        $result  = $consonants->getScore();
        $message = 'Should return 0; filter is off.';
        $this->assertEquals($expected, $result, $message);

        $text       = 'bcdfgbcdfgbcdfg bcdfg'; //four sets of 5 consonants
        $consonants = new Consonants($this->increase, $text);
        $expected   = $this->increase * 4;
        $consonants->setScore();
        $result  = $consonants->getScore();
        $message = 'Should return $increase * 4';
        $this->assertEquals($expected, $result, $message);

        $text       = 'Lorem Ipsum Dolar Sit Tecum';
        $consonants = new Consonants($this->increase, $text);
        $expected   = 0;
        $consonants->setScore();
        $result  = $consonants->getScore();
        $message = 'Should return 0 since there are no matches';
        $this->assertEquals($expected, $result, $message);

        $this->assertInstanceOf('\CmdZ\SpamCanner\Filters\FilterInterface', $consonants);
    }
}
