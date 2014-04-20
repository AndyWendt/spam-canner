<?php namespace CmdZ\SpamCanner\Tests\Filters;

use Mockery;

class FilterAbstractTest extends \PHPUnit_Framework_TestCase
{


    public function testGetName()
    {
        $utils = Mockery::mock('\CmdZ\SpamCanner\Filters\FilterUtilitiesInterface');
        $utils->shouldReceive('getClassName')->once()->andReturn('mocked');

        $mock = Mockery::mock('\CmdZ\SpamCanner\Filters\FilterAbstract')->shouldDeferMissing();
        /** @var \CmdZ\SpamCanner\Filters\FilterAbstract $mock */
        $result   = $mock->getName($utils);
        $expected = 'mocked';
        $this->assertSame($expected, $result);
    }
}
