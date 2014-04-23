<?php namespace CmdZ\SpamCanner\Filters;

class LinksInBody extends FilterAbstract
{
    protected $linkCount;
    protected $increase;
    protected $decrease;
    protected $threshold;
    protected $score;

    public function __construct($increase, $decrease, $threshold, $linkCount)
    {
        $this->decrease  = $decrease;
        $this->increase  = $increase;
        $this->linkCount = $linkCount;
        $this->threshold = $threshold;
    }

    protected function calcScore()
    {
        if ($this->threshold < 0) return 0; // Filter is set to off: -1
        if ($this->linkCount < $this->threshold) return -$this->decrease;
        if ($this->linkCount >= $this->threshold) return $this->linkCount * $this->increase;
        return 0;
    }
}
