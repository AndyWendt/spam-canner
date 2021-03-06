<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\CheckAuthorNameForLink;

class CheckAuthorNameForLinkTest extends \PHPUnit_Framework_TestCase
{
    protected $interface = '\CmdZ\SpamCanner\Filters\FilterInterface';
    protected $filterClass = '\CmdZ\SpamCanner\Filters\CheckAuthorNameForLink';
    protected $increase = 2;
    protected $off = -1;

    public function testImplementsInterface()
    {
        $mockedClass = \Mockery::mock($this->filterClass);
        $this->assertInstanceOf($this->interface, $mockedClass);
    }

    public function testFilterIsOff()
    {
        $name = '<a href="http://test.com">test</a> <a href="https://test.com">name</a>';
        $authorNameCheck = new CheckAuthorNameForLink($this->off, $name);
        $expected = 0;
        $authorNameCheck->setScore();
        $result = $authorNameCheck->getScore();
        $message = 'Should return 0; filter is off.';
        $this->assertEquals($expected, $result, $message);
    }

    public function testIncreaseSpamScore()
    {
        $name = '<a href="http://test.com">test</a> <a href="https://test.com">name</a>';
        $authorNameCheck = new CheckAuthorNameForLink($this->increase, $name);
        $expected = $this->increase * 2;
        $authorNameCheck->setScore();
        $result = $authorNameCheck->getScore();
        $message = 'Should Return $increase * 2';
        $this->assertEquals($expected, $result, $message);
    }

    public function testNoInfluenceSpamScore()
    {
        $name = 'Test Name';
        $authorNameCheck = new CheckAuthorNameForLink($this->increase, $name);
        $expected = 0;
        $authorNameCheck->setScore();
        $result = $authorNameCheck->getScore();
        $message = 'Should return 0';
        $this->assertEquals($expected, $result, $message);
    }
}
