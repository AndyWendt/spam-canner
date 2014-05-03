<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\UrlLength;

class UrlLengthTest extends \PHPUnit_Framework_TestCase
{
    protected $interface = '\CmdZ\SpamCanner\Filters\FilterInterface';
    protected $filterClass = '\CmdZ\SpamCanner\Filters\UrlLength';
    protected $increase = 1;
    protected $threshold = 30;
    protected $off = -1;

    public function testImplementsInterface()
    {
        $mockedFilterClass = \Mockery::mock($this->filterClass);
        $this->assertInstanceOf($this->interface, $mockedFilterClass);
    }

    public function testFilterIsOff()
    {
        $link = 'http://1234567890123456789012345678901';
        $urlLength = new UrlLength($this->increase, $this->off, $link);
        $urlLength->setScore();
        $result = $urlLength->getScore();
        $message = 'Should return 0; filter is off.';
        $this->assertEquals(0, $result, $message);
    }

    public function testIncreaseSpamScore()
    {
        $link = 'http://1234567890123456789012345678901';
        $urlLength = new UrlLength($this->increase, $this->threshold, $link);
        $expected = $this->increase;
        $urlLength->setScore();
        $result = $urlLength->getScore();
        $message = 'Should return $increase';
        $this->assertEquals($expected, $result, $message);
    }

    public function testNoInfluenceSpamScore()
    {
        $link = 'http://12345678901234567890123456';
        $urlLength = new UrlLength($this->increase, $this->threshold, $link);
        $expected = 0;
        $urlLength->setScore();
        $result = $urlLength->getScore();
        $message = 'Should remove http:// and return 0';
        $this->assertEquals($expected, $result, $message);
    }
}
