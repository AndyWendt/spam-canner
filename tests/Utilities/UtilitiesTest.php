<?php namespace CmdZ\SpamCanner\Tests\Utilities;

use CmdZ\SpamCanner\Utilities\Utilities;
use Mockery;

class UtilitiesTest extends \PHPUnit_Framework_TestCase
{

    /** @var  Utilities */
    protected $utils;

    public function setUp()
    {
        $this->utils = new Utilities();
    }

    public function tearDown()
    {
        Mockery::close();
    }


    public function testFindLinks()
    {
        $this->utils = new Utilities();
        $urls[] = 'www.apple.com';
        $urls[] = 'http://microsoft.com';
        $doesNotContain[] = 'me.com';
        $text = 'aslfd alskjf asldfj ' . $urls[0] . ' ;lasdfjl . ' . $doesNotContain[0] . 'a;slfd ' .
            $urls[1] . ' asdflj';
        $result = $this->utils->findLinks($text);

        $this->assertContains($urls[0], $result);
        $this->assertContains($urls[1], $result);
        $this->assertNotContains($doesNotContain[0], $result);
    }

    public function testGetClassName()
    {
        $expected = 'stdClass';
        $sc = new \stdClass();
        $result = $this->utils->getClassName($sc);
        $this->assertSame($expected, $result);

        $expected = 'UtilitiesTest';
        $ut = new self();
        $result = $this->utils->getClassName($ut);
        $this->assertSame($expected, $result);
    }


    /**
     * @method arrayContainsOnlyInstancesOf()
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $obj not instance of $class
     */
    public function it_throws_if_not_an_instance_of_class()
    {
        $interface = 'SplSubject';
        $interfaceMock = Mockery::mock($interface);
        $class = 'stdClass';
        $classMock = Mockery::mock($class);
        $haystack = [$classMock, $interfaceMock];
        $this->utils->arrayContainsOnlyInstancesOf($class, $haystack);
    }

    /**
     * @method arrayContainsOnlyInstancesOf()
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Class does not exist
     */
    public function it_throws_if_class_doesnt_exits()
    {
        $exception = 'asdlfj';
        $haystack = [$exception, $exception];
        $this->utils->arrayContainsOnlyInstancesOf($exception, $haystack);
    }

    /**
     * @method arrayContainsOnlyInstancesOf()
     * @test
     */
    public function it_returns_true_if_only_instances_of_class()
    {
        $interface = 'SplSubject';
        $mock = Mockery::mock($interface);
        $haystack = [$mock, $mock];
        $result = $this->utils->arrayContainsOnlyInstancesOf($interface, $haystack);
        $this->assertSame(true, $result);

        $class = 'stdClass';
        $mock = Mockery::mock($class);
        $haystack = [$mock, $mock];
        $result = $this->utils->arrayContainsOnlyInstancesOf($class, $haystack);
        $this->assertSame(true, $result);
    }
}
