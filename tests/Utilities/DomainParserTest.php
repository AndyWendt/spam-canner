<?php namespace CmdZ\SpamCanner\Tests\Utilities;

use CmdZ\SpamCanner\Utilities\DomainParser;

class DomainParserTest extends \PHPUnit_Framework_TestCase
{

    /** @var  \Mockery\Mock */
    protected $pdp;

    /** @var  DomainParser */
    protected $parser;

    protected $stdClass;

    protected $url;

    public function setUp()
    {
        parent::setUp(); //
        $this->pdp      = \Mockery::mock('\Pdp\Parser');
        $this->stdClass = new \stdClass();
    }

    public function testGetTld()
    {
        $tld = 'com';

        $suffix               = clone $this->stdClass;
        $suffix->publicSuffix = $tld;

        $host       = clone $this->stdClass;
        $host->host = $suffix;

        $this->pdp->shouldReceive('parseUrl')->andReturn($host);
        $this->url    = 'www.apple.com';
        $this->parser = new DomainParser($this->pdp);
        $this->parser->setUrl($this->url);
        $result = $this->parser->getTld();
        $this->assertSame($tld, $result);
    }
}
