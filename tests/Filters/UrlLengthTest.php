<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\UrlLength;

class UrlLengthTest extends \PHPUnit_Framework_TestCase
{

    protected $increase = 1;
    protected $threshold = 30;
    protected $off = -1;

    public function testSetScore()
    {
        $link      = 'http://1234567890123456789012345678901';
        $urlLength = new UrlLength($this->increase, $this->off, $link);
        $urlLength->setScore();
        $result  = $urlLength->getScore();
        $message = 'Should return 0; filter is off.';
        $this->assertEquals(0, $result, $message);

        $link      = 'http://1234567890123456789012345678901';
        $urlLength = new UrlLength($this->increase, $this->threshold, $link);
        $expected  = $this->increase;
        $urlLength->setScore();
        $result  = $urlLength->getScore();
        $message = 'Should return $increase';
        $this->assertEquals($expected, $result, $message);

        $link      = 'http://12345678901234567890123456';
        $urlLength = new UrlLength($this->increase, $this->threshold, $link);
        $expected  = 0;
        $urlLength->setScore();
        $result  = $urlLength->getScore();
        $message = 'Should remove http:// and return 0';
        $this->assertEquals($expected, $result, $message);

        $this->assertInstanceOf('\CmdZ\SpamCanner\Filters\FilterInterface', $urlLength);
    }
}
