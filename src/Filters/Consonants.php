<?php namespace CmdZ\SpamCanner\Filters;

class Consonants extends FilterAbstract
{
    protected $text;
    protected $increase;

    public function __construct($increase, $text)
    {
        $this->increase = $increase;
        $this->text     = $text;
    }

    protected function calcScore()
    {
        if ($this->increase <= 0) return 0; // Filter set to off: -1
        preg_match_all('/[bcdfghjklmnpqrstvwxz]{5}/i', $this->text, $matches); // matches 6 or more consonants
        return count($matches[0]) * $this->increase;
    }
}
