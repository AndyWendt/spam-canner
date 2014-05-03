<?php namespace CmdZ\SpamCanner\Filters;

class BodyLength extends FilterAbstract
{

    protected $text;
    protected $linkCount;
    protected $increase;
    protected $decrease;
    protected $threshold;

    public function __construct($increase, $decrease, $threshold, $text, $linkCount)
    {
        $this->decrease = $decrease;
        $this->increase = $increase;
        $this->linkCount = $linkCount;
        $this->text = $text;
        $this->threshold = $threshold;
    }


    protected function calcScore()
    {
        if ($this->threshold < 0) return 0; // Filter is set to off: -1
        $length = strlen(str_replace(' ', '', $this->text));
        if (($length > $this->threshold) && ($this->linkCount == 0)) return -$this->decrease;
        if ($length < $this->threshold) return $this->increase;
        return 0;
    }
}
