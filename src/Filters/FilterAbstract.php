<?php namespace CmdZ\SpamCanner\Filters;

abstract class FilterAbstract implements FilterInterface
{
    protected $off = -1;
    protected $score;

    abstract protected function calcScore();

    public function setScore()
    {
        $score = $this->calcScore();
        $this->score = $score;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function getName(FilterUtilitiesInterface $utilities)
    {
        return $utilities->getClassName($this);
    }
}
