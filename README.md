# Spam Canner

[![Build Status](https://travis-ci.org/AndyWendt/spam-canner.svg?branch=master)](https://travis-ci.org/AndyWendt/spam-canner) [![Coverage Status](https://coveralls.io/repos/AndyWendt/spam-canner/badge.png?branch=master)](https://coveralls.io/r/AndyWendt/spam-canner?branch=master)

Extensible Spam Detection Filters.

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


## Testing

``` bash
$ phpunit
```



## License

The MIT License (MIT). Please see the License File for more information.
