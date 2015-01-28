# Spam Canner

[![Build Status](https://travis-ci.org/AndyWendt/spam-canner.svg?branch=master)](https://travis-ci.org/AndyWendt/spam-canner) [![Coverage Status](https://coveralls.io/repos/AndyWendt/spam-canner/badge.png?branch=master)](https://coveralls.io/r/AndyWendt/spam-canner?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/AndyWendt/spam-canner/badges/quality-score.png?s=c0bfd2087557a239164fa451f353d52a82a83d80)](https://scrutinizer-ci.com/g/AndyWendt/spam-canner/)

Extensible Spam Detection Filters based on this [snook.ca post](http://snook.ca/archives/other/effective_blog_comment_spam_blocker)

## Usage

Filters are located in the `src/Filters` directory.
You can add your own filters as well, they just need to implement `CmdZ\SpamCanner\Filters\FilterInterface` and then add them
to the `$filters` array that you pass to `Score()`

```php

$spamScoreIncrease = 1;
$currentCommentBody = 'abcd';
$previousCommentBody = 'abcd';

$testLink = 'http://www.site.de';
$spammyTlds = ['de'];
$domainParser = new \CmdZ\SpamCanner\Utilities\DomainParser;

$filters = [
  new BodyInPreviousComment($spamScoreIncrease, $currentCommentBody, $previousCommentBody),
  new Tlds($spamScoreIncrease, $testLink, $spammyTlds, $domainParser)
];

$utils = new \CmdZ\SpamCanner\Utilities\Utilities;
$score    = new Score($filters, $utils);
$result   = $score->getScore();
$expected = 2;

```

## Available Filters

See [snook.ca post](http://snook.ca/archives/other/effective_blog_comment_spam_blocker) for the ideas behind each filter.

* [Body in Previous Comment](tests/Filters/BodyInPreviousCommentTest.php)
* [Body Length](tests/Filters/BodyLengthTest.php)
* [Check Auth Name for Link](tests/Filters/CheckAuthorNameForLinkTest.php)
* [Consonants](tests/Filters/ConsonantsTest.php)
* [First Word](tests/Filters/FirstWordTest.php)
* [Links in Body](tests/Filters/LinksInBodyTest.php)
* [Status of Previous Comment](tests/Filters/StatusOfPreviousCommentTest.php)
* [Tlds](tests/Filters/TldsTest.php)
* [Url Length](tests/Filters/UrlLengthTest.php)
* [Words Characters in Url](tests/Filters/UrlWordsCharactersTest.php)


## Testing

``` bash
$ phpunit
```



## License

The MIT License (MIT). Please see the License File for more information.
