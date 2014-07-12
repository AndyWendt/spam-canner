<?php namespace CmdZ\SpamCanner\Tests\Integration;

use CmdZ\SpamCanner\Utilities\DomainParser;

class DomainParserTest extends \PHPUnit_Framework_TestCase
{


    public function testIntegrationOfDomainParserWithPdp()
    {
        // test that it works if used correctly.
        $parser = new DomainParser();
        $parser->setUrl('http://www.apple.cn');
        $tld = $parser->getTld();
        $expected = 'cn';
        $this->assertSame($expected, $tld);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testException()
    {
        // throw \InvalidArgumentException because $url is not set;
        $parser = new DomainParser();
        $parser->getTld();
    }
}
