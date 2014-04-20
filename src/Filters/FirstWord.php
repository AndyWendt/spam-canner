<?php namespace CmdZ\SpamCanner\Filters;

class FirstWord extends FilterAbstract
{
    protected $text;
    protected $increase;
    protected $firstWordList;

    public function __construct(array $firstWordList, $increase, $text)
    {
        $this->firstWordList = $firstWordList;
        $this->increase      = $increase;
        $this->text          = $text;
    }


    protected function calcScore()
    {
        if ($this->increase <= 0) return 0; // filter set to off
        $firstWord = $this->getWordFromText();
        if (in_array($firstWord, $this->firstWordList)) return $this->increase;
        return 0;
    }

    protected function getWordFromText()
    {
        $firstWord = strtolower(strtok($this->text, ' '));
        return preg_replace('/[^A-Za-z0-9\-]/', '', $firstWord); // remove special chars
    }
}
