<?php namespace CmdZ\SpamCanner\Filters;

interface FilterInterface
{
    public function setScore();

    public function getScore();

    public function getName(FilterUtilitiesInterface $utilities);
}
