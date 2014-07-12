<?php namespace CmdZ\SpamCanner\Tests\Filters;

use CmdZ\SpamCanner\Filters\BodyLength;

class BodyLengthTest extends \PHPUnit_Framework_TestCase
{
    protected $interface = '\CmdZ\SpamCanner\Filters\FilterInterface';
    protected $filterClass = '\CmdZ\SpamCanner\Filters\BodyLength';
    protected $decrease = 2;
    protected $increase = 1;
    protected $threshold = 20;
    protected $off = -1;

    /** @test */
    public function it_implements_the_filter_interface()
    {
        $mockedClass = \Mockery::mock($this->filterClass);
        $this->assertInstanceOf($this->interface, $mockedClass);
    }

    /** @test */
    public function it_returns_zero_if_passed_negative_number_as_threshold()
    {
        $text = 'asdfasdf';
        $link_count = 22;
        $bodyLength = new BodyLength($this->increase, $this->decrease, $this->off, $text, $link_count);
        $bodyLength->setScore();

        $result = $bodyLength->getScore();
        $expected = 0;
        $message = 'Should return 0; filter is off.';
        $this->assertEquals($expected, $result, $message);
    }

    /** @test */
    public function it_increases_spam_score_if_text_is_too_short()
    {
        $text = 'asdfasdf';
        $link_count = 2;
        $bodyLength = new BodyLength($this->increase, $this->decrease, $this->threshold, $text, $link_count);
        $bodyLength->setScore();

        $result = $bodyLength->getScore();
        $expected = $this->increase;
        $message = 'Should return $increase because text is too short.';
        $this->assertEquals($expected, $result, $message);
    }

    /** @test */
    public function it_doesnt_influence_spam_score_if_links_are_present_and_string_is_long_enough()
    {
        $text = 'asdf;as as;ldfj asldf; as;lfd as;ldf';
        $link_count = 2;
        $bodyLength = new BodyLength($this->increase, $this->decrease, $this->threshold, $text, $link_count);
        $bodyLength->setScore();

        $result = $bodyLength->getScore();
        $expected = 0;
        $message = 'Should return 0 since links are present';
        $this->assertEquals($expected, $result, $message);
    }

    /** @test */
    public function it_decreases_score_if_there_are_no_links_and_string_is_long_enough()
    {
        $text = 'as;ldflsjfd a;lsdfj ;laskfj as;lfdj as;lfdj';
        $link_count = 0;
        $bodyLength = new BodyLength($this->increase, $this->decrease, $this->threshold, $text, $link_count);
        $bodyLength->setScore();

        $result = $bodyLength->getScore();
        $expected = -$this->decrease;
        $message = 'Should return -$decrease since no links & > threshold';
        $this->assertEquals($expected, $result, $message);
    }
}
