<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\Tlds;
use Mockery;

class TldsTest extends \PHPUnit_Framework_TestCase
{
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

    public function testSetScore()
    {
        $link = 'http://www.apple.cn';
        $this->parser->shouldReceive('setUrl')->once()->with($link);
        $this->parser->shouldReceive('getTld')->never();
        $tlds     = new Tlds($this->off, $link, $this->spammyTldList, $this->parser);
        $expected = 0;
        $tlds->setScore();
        $result  = $tlds->getScore();
        $message = 'Should return 0; filter is off.';
        $this->assertEquals($expected, $result, $message);

        $link = 'http://www.apple.cn';
        $this->parser->shouldReceive('setUrl')->once()->with($link);
        $this->parser->shouldReceive('getTld')->once()->andReturn('cn');
        $tlds     = new Tlds($this->increase, $link, $this->spammyTldList, $this->parser);
        $expected = $this->increase;
        $tlds->setScore();
        $result  = $tlds->getScore();
        $message = 'Should equal $increase';
        $this->assertEquals($expected, $result, $message);

        $link = 'www.apple.com';
        $this->parser->shouldReceive('setUrl')->once()->with($link);
        $this->parser->shouldReceive('getTld')->once()->with($link)->andReturn('com');
        $tlds     = new Tlds($this->increase, $link, $this->spammyTldList, $this->parser);
        $expected = 0;
        $tlds->setScore();
        $result  = $tlds->getScore();
        $message = 'Should equal 0 because there is no match';
        $this->assertEquals($expected, $result, $message);

        $this->assertInstanceOf('\CmdZ\SpamCanner\Filters\FilterInterface', $tlds);
    }
}
