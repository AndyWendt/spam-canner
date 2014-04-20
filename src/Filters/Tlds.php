<?php namespace CmdZ\SpamCanner\Filters;

use CmdZ\SpamCanner\Utilities\DomainParserInterface;

class Tlds extends FilterAbstract
{
    protected $link;
    protected $increase;
    protected $spammyTldList;

    protected $parser;

    public function __construct($increase, $link, array $spammyTldList, DomainParserInterface $parser)
    {
        $this->increase      = $increase;
        $this->link          = $link;
        $this->spammyTldList = $spammyTldList;
        $this->parser        = $parser;
        $this->parser->setUrl($link);
    }


    protected function calcScore()
    {
        if ($this->increase <= 0) return 0;
        $tld = $this->parser->getTld($this->link);
        if ($tld === false) return 0;
        if (in_array($tld, $this->spammyTldList)) return $this->increase;
        return 0;
    }
}
