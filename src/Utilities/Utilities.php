<?php namespace CmdZ\SpamCanner\Utilities;

use CmdZ\SpamCanner\Filters\FilterUtilitiesInterface;
use CmdZ\SpamCanner\ScoreUtilitiesInterface;
use ReflectionClass;

class Utilities implements FilterUtilitiesInterface, ScoreUtilitiesInterface
{

    public function findLinks($text)
    {
        // Regex by John Gruber: http://daringfireball.net/2010/07/improved_regex_for_matching_urls
        // License: Public Domain
        $regex = '~(?i)\b((?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()
        <>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))~';
        preg_match_all($regex, $text, $links_array);
        return $links_array[0];
    }

    public function getClassName($object)
    {
        $reflect = new ReflectionClass($object);
        return $reflect->getShortName();
    }

    /**
     * @param       $class
     * @param array $haystack
     *
     * @return bool
     * @throws \InvalidArgumentException if class or interface does not exist
     */
    public function arrayContainsOnlyInstancesOf($class, array $haystack)
    {
        if (!interface_exists($class) && !class_exists($class)) {
            throw new \InvalidArgumentException(
                'Class does not exist'
            );
        }
        foreach ($haystack as $obj) {
            if ($obj instanceof $class) continue;
            throw new \InvalidArgumentException(
                '$obj not instance of $class'
            );
        }
        return true;
    }
}
