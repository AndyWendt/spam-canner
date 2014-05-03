<?php namespace CmdZ\SpamCanner\Tests;

use CmdZ\SpamCanner\Score;
use Mockery;

class ScoreTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Mockery\Mock */
    protected $filterInterface;

    /** @var  Mockery\Mock */
    protected $scoreUtilitiesInterface;

    public function setUp()
    {
        parent::setUp();
        $this->filterInterface = Mockery::mock('\CmdZ\SpamCanner\Filters\FilterInterface');
        $this->scoreUtilitiesInterface = Mockery::mock('\CmdZ\SpamCanner\ScoreUtilitiesInterface');
    }


    public function tearDown()
    {
        Mockery::close();
    }

    public function testGetScore()
    {
        $i = 2;
        $n = 2;
        $this->filterInterface->shouldReceive('setScore')->times($i);
        $this->filterInterface->shouldReceive('getScore')->times($i)->andReturn($n);
        $this->scoreUtilitiesInterface->shouldReceive('arrayContainsOnlyInstancesOf')->once()->andReturn(true);
        $score = new Score([$this->filterInterface, $this->filterInterface], $this->scoreUtilitiesInterface);

        $result = $score->getScore();
        $this->assertSame($n * $i, $result);
    }
}
