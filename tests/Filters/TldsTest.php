<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\Tlds;
use Mockery;

class TldsTest extends \PHPUnit_Framework_TestCase
{
    protected $interface = '\CmdZ\SpamCanner\Filters\FilterInterface';
    protected $filterClass = '\CmdZ\SpamCanner\Filters\Tlds';
    protected $increase = 1;
    protected $spammyTldList = ['cn', 'de', 'pl'];
    protected $off = -1;

    /** @var  Mockery\Mock */
    protected $parser;

    protected function setUp()
    {
        parent::setUp();
        $this->parser = Mockery::mock('\CmdZ\SpamCanner\Utilities\DomainParserInterface');
    }

    protected function tearDown()
    {
        Mockery::close();
    }

    public function testImplementsInterface()
    {
        $tlds = Mockery::mock($this->filterClass);
        $this->assertInstanceOf($this->interface, $tlds);
    }

    public function testFilterIsOff()
    {
        $link = 'http://www.apple.cn';
        $this->parser->shouldReceive('setUrl')->once()->with($link);
        $this->parser->shouldReceive('getTld')->never();
        $tlds = new Tlds($this->off, $link, $this->spammyTldList, $this->parser);
        $tlds->setScore();

        $result = $tlds->getScore();
        $expected = 0;
        $message = 'Should return 0; filter is off.';
        $this->assertEquals($expected, $result, $message);
    }

    public function testIncreaseSpamScore()
    {
        $link = 'http://www.apple.cn';
        $this->parser->shouldReceive('setUrl')->once()->with($link);
        $this->parser->shouldReceive('getTld')->once()->andReturn('cn');
        $tlds = new Tlds($this->increase, $link, $this->spammyTldList, $this->parser);
        $tlds->setScore();

        $result = $tlds->getScore();
        $expected = $this->increase;
        $message = 'Should equal $increase';
        $this->assertEquals($expected, $result, $message);
    }

    public function testNoInfluenceSpamScore()
    {
        $link = 'www.apple.com';
        $this->parser->shouldReceive('setUrl')->once()->with($link);
        $this->parser->shouldReceive('getTld')->once()->with()->andReturn('com');
        $tlds = new Tlds($this->increase, $link, $this->spammyTldList, $this->parser);
        $tlds->setScore();

        $result = $tlds->getScore();
        $expected = 0;
        $message = 'Should equal 0 because there is no match';
        $this->assertEquals($expected, $result, $message);
    }

}
