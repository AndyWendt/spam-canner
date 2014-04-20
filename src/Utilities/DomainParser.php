<?php namespace CmdZ\SpamCanner\Utilities;

use Pdp\Parser;
use Pdp\PublicSuffixListManager;

class DomainParser implements DomainParserInterface
{
    protected $url;

    /** @var  \Pdp\Parser */
    protected $pdp;

    public function __construct()
    {
        $psl       = new PublicSuffixListManager();
        $pdp       = new Parser($psl->getList());
        $this->pdp = $pdp;
    }

    public function getTld()
    {
        $url = $this->pdp->parseUrl($this->url);
        return $url->host->publicSuffix;
    }

    public function setUrl($url)
    {
        return $this->url = $url;
    }
}
