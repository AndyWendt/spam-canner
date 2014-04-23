<?php namespace CmdZ\SpamCanner\Filters;

class UrlLength extends FilterAbstract
{
    protected $link;
    protected $increase;
    protected $threshold;

    public function __construct($increase, $threshold, $link)
    {
        $this->increase  = $increase;
        $this->link      = $link;
        $this->threshold = $threshold;
    }

    protected function calcScore()
    {
        if ($this->threshold < 0) return 0;
        $url_length = strlen(str_replace(array('http://', 'https://'), '', $this->link));
        if ($url_length > $this->threshold) return $this->increase;
        return 0;
    }
}
