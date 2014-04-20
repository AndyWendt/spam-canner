<?php namespace CmdZ\SpamCanner\Filters;

class UrlWordsCharacters extends FilterAbstract
{
    protected $link;
    protected $increase;
    protected $wordsCharsArray;

    public function __construct($increase, $link, array $wordsCharsArray)
    {
        $this->increase        = $increase;
        $this->link            = $link;
        $this->wordsCharsArray = $wordsCharsArray;
    }


    protected function calcScore()
    {
        if ($this->increase <= 0) return 0; // Filter set to off: -1
        $spam_score = array(0);
        foreach ($this->wordsCharsArray as $wordChar) {
            $spam_score[] = $this->increase * substr_count($this->link, $wordChar);
        }
        return array_sum($spam_score);
    }
}
