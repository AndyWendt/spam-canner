<?php namespace CmdZ\SpamCanner\Tests\Integration;

use CmdZ\SpamCanner\Filters\BodyInPreviousComment;
use CmdZ\SpamCanner\Filters\Tlds;
use CmdZ\SpamCanner\Score;

class ScoreIntegrationTest extends \PHPUnit_Framework_TestCase
{

    public function testIntegrationOfScoreClass()
    {
        $spamScoreIncrease = 1;
        $currentCommentBody = 'abcd';
        $previousCommentBody = 'abcd';

        $testLink = 'http://www.site.de';
        $spammyTlds = ['de'];
        $domainParser = new \CmdZ\SpamCanner\Utilities\DomainParser;

        $filters = [
          new BodyInPreviousComment($spamScoreIncrease, $currentCommentBody, $previousCommentBody),
          new Tlds($spamScoreIncrease, $testLink, $spammyTlds, $domainParser)
        ];

        $utils = new \CmdZ\SpamCanner\Utilities\Utilities;
        $score    = new Score($filters, $utils);
        $result   = $score->getScore();
        $expected = 2;

        $this->assertSame($expected, $result);
    }
}
