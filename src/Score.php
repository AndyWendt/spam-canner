<?php namespace CmdZ\SpamCanner;

class Score
{
    protected $filterInterface = '\CmdZ\SpamCanner\Filters\FilterInterface';

    /** @var \CmdZ\SpamCanner\Filters\FilterInterface[] */
    protected $filters;

    protected $score;

    /** @var  ScoreUtilitiesInterface */
    protected $utils;

    public function __construct(array $filters, ScoreUtilitiesInterface $utils)
    {
        $utils->arrayContainsOnlyInstancesOf($this->filterInterface, $filters);
        $this->filters = $filters;
    }

    public function getScore()
    {
        $this->score = $this->calcScore();
        return $this->score;
    }

    public function calcScore()
    {
        $scoreArray = array_map(
            function ($filter) {
                /** @var \CmdZ\SpamCanner\Filters\FilterInterface $filter */
                $filter->setScore();
                return $filter->getScore();
            },
            $this->filters
        );
        return array_sum($scoreArray);
    }
}
