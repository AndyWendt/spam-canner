<?php namespace CmdZ\SpamCanner\Tests\Integration;

use CmdZ\SpamCanner\Filters\Tlds;
use CmdZ\SpamCanner\Utilities\DomainParser;

class TldsIntegrationTest extends \PHPUnit_Framework_TestCase
{


    public function testIntegrationOfTldsAndPdp()
    {
        $increase = 1;
        $spammyTldList = ['cn'];
        $link = 'http://www.apple.cn';
        $parser = new DomainParser();
        $tlds = new Tlds($increase, $link, $spammyTldList, $parser);

        $tlds->setScore();
        $result = $tlds->getScore();
        $expected = $increase;
        $this->assertSame($expected, $result);
    }
}
