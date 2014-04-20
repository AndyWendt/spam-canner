<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\LinksInBody;

class LinksInBodyTest extends \PHPUnit_Framework_TestCase
{
    protected $increase = 1;
    protected $decrease = 2;
    protected $threshold = 2;
    protected $off = -1;

    /** @var LinksInBody */
    protected $lib;

    public function testSetScore()
    {
        $link_count = 100;
        $this->lib  = new LinksInBody($this->decrease, $this->increase, $link_count, $this->threshold);
        $this->lib->setScore();
        $result   = $this->lib->getScore();
        $expected = $link_count * $this->increase;
        $message  = '100 links should return 100 * $increase';
        $this->assertEquals($expected, $result, $message);

        $link_count = null;
        $this->lib  = new LinksInBody($this->decrease, $this->increase, $link_count, $this->threshold);
        $this->lib->setScore();
        $result   = $this->lib->getScore();
        $expected = -$this->decrease;
        $message  = 'null should return decrease';
        $this->assertEquals($expected, $result, $message);

        $link_count = 12;
        $this->lib  = new LinksInBody($this->decrease, $this->increase, $link_count, $this->off);
        $this->lib->setScore();
        $result   = $this->lib->getScore();
        $expected = 0;
        $message  = 'Should return 0; filter is off.';
        $this->assertEquals($expected, $result, $message);

        $this->assertInstanceOf('\CmdZ\SpamCanner\Filters\FilterInterface', $this->lib);
    }
}
