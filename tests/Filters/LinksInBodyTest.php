<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\LinksInBody;

class LinksInBodyTest extends \PHPUnit_Framework_TestCase
{
    protected $interface = '\CmdZ\SpamCanner\Filters\FilterInterface';
    protected $filterClass = 'CmdZ\SpamCanner\Filters\LinksInBody';
    protected $increase = 1;
    protected $decrease = 2;
    protected $threshold = 2;
    protected $off = -1;

    /** @var LinksInBody */
    protected $lib;

    public function testImplementsInterface()
    {
        $mockedFilterClass = \Mockery::mock($this->filterClass);
        $this->assertInstanceOf($this->interface, $mockedFilterClass);
    }

    public function testIncreaseSpamScore()
    {
        $link_count = 100;
        $this->lib = new LinksInBody($this->increase, $this->decrease, $this->threshold, $link_count);
        $this->lib->setScore();
        $result = $this->lib->getScore();
        $expected = $link_count * $this->increase;
        $message = '100 links should return 100 * $increase';
        $this->assertEquals($expected, $result, $message);
    }

    public function testDecreaseSpamScore()
    {
        $link_count = null;
        $this->lib = new LinksInBody($this->increase, $this->decrease, $this->threshold, $link_count);
        $this->lib->setScore();
        $result = $this->lib->getScore();
        $expected = -$this->decrease;
        $message = 'null link counts should return decrease';
        $this->assertEquals($expected, $result, $message);
    }

    public function testNoInfluenceSpamScore()
    {
        $link_count = 12;
        $this->lib = new LinksInBody($this->increase, $this->decrease, $this->off, $link_count);
        $this->lib->setScore();
        $result = $this->lib->getScore();
        $expected = 0;
        $message = 'Should return 0; filter is off.';
        $this->assertEquals($expected, $result, $message);
    }
}
