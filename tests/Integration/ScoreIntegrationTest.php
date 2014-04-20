<?php namespace CmdZ\SpamCanner\Tests\Integration;

use CmdZ\SpamCanner\Filters\BodyInPreviousComment;
use CmdZ\SpamCanner\Filters\Tlds;
use CmdZ\SpamCanner\Score;
use CmdZ\SpamCanner\Utilities\DomainParser;
use CmdZ\SpamCanner\Utilities\Utilities;

class ScoreIntegrationTest extends \PHPUnit_Framework_TestCase
{

    public function testIntegrationOfScoreClass()
    {
        $filters = [
          new BodyInPreviousComment('abcd', 1, 'abcd'),
          new Tlds(1, 'http://www.apple.de', ['de'], new DomainParser())
        ];

        $score    = new Score($filters, new Utilities());
        $result   = $score->getScore();
        $expected = 2;

        $this->assertSame($expected, $result);
    }
}
