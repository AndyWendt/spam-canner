<?php namespace CmdZ\SpamCanner\Tests\Integration;

use CmdZ\SpamCanner\Filters\BodyInPreviousComment;
use CmdZ\SpamCanner\Filters\Tlds;
use CmdZ\SpamCanner\Score;
use \CmdZ\SpamCanner\Utilities\DomainParser;
use \CmdZ\SpamCanner\Utilities\Utilities;

class ScoreIntegrationTest extends \PHPUnit_Framework_TestCase
{

    public function testIntegrationOfScoreClass()
    {
        $spamScoreIncrease = 1;
        $currentCommentBody = 'abcd';
        $previousCommentBody = 'abcd';

        $testLink = 'http://www.site.de';
        $spammyTlds = ['de'];
        $domainParser = new DomainParser();

        $filters = [
            new BodyInPreviousComment($spamScoreIncrease, $currentCommentBody, $previousCommentBody),
            new Tlds($spamScoreIncrease, $testLink, $spammyTlds, $domainParser)
        ];

        $utils = new Utilities();
        $score = new Score($filters, $utils);
        $result = $score->getScore();
        $expected = 2;

        $this->assertSame($expected, $result);
    }
}
