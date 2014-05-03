<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\UrlWordsCharacters;

class UrlWordsCharactersTest extends \PHPUnit_Framework_TestCase
{
    protected $interface = '\CmdZ\SpamCanner\Filters\FilterInterface';
    protected $filterClass = '\CmdZ\SpamCanner\Filters\UrlWordsCharacters';
    protected $increase = 1;
    protected $wordsCharsList = ['test', 'spam'];
    protected $off = -1;

    public function testImplementsInterface()
    {
        $mockedFilterClass = \Mockery::mock($this->filterClass);
        $this->assertInstanceOf($this->interface, $mockedFilterClass);
    }

    public function testFilterIsOff()
    {
        $link = 'http://testing.com/spam';
        $urlWordsChars = new UrlWordsCharacters($this->off, $link, $this->wordsCharsList);
        $expected = 0;
        $urlWordsChars->setScore();
        $result = $urlWordsChars->getScore();
        $message = 'Returns 0 because increase is set to -1';
        $this->assertEquals($expected, $result, $message);
    }

    public function testIncreaseSpamScore()
    {
        $link = 'http://testing.com/spam';
        $urlWordsChars = new UrlWordsCharacters($this->increase, $link, $this->wordsCharsList);
        $expected = $this->increase * 2;
        $urlWordsChars->setScore();
        $result = $urlWordsChars->getScore();
        $message = 'Should equal $increase * 2';
        $this->assertEquals($expected, $result, $message);
    }

    public function testNoInfluenceSpamScore()
    {
        $link = 'http://none.com/';
        $urlWordsChars = new UrlWordsCharacters($this->increase, $link, $this->wordsCharsList);
        $expected = 0;
        $urlWordsChars->setScore();
        $result = $urlWordsChars->getScore();
        $message = 'should equal 0 since there are no matches';
        $this->assertEquals($expected, $result, $message);
    }
}
