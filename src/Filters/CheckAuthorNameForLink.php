<?php namespace CmdZ\SpamCanner\Filters;

class CheckAuthorNameForLink extends FilterAbstract
{
    protected $name;
    protected $increase;

    public function __construct($increase, $name)
    {
        $this->increase = $increase;
        $this->name = $name;
    }

    protected function calcScore()
    {
        if ($this->increase <= 0) return 0;
        $count = array(0);
        $needles = array('http://', 'https://');
        foreach ($needles as $search) {
            $count[] = substr_count($this->name, $search);
        }
        return array_sum($count) * $this->increase;
    }
}
