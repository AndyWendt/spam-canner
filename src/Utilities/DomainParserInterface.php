<?php namespace CmdZ\SpamCanner\Utilities;

interface DomainParserInterface
{
    public function getTld();

    public function setUrl($url);
}
