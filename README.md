# Spam Canner

[![Build Status](https://travis-ci.org/AndyWendt/spam-canner.svg?branch=master)](https://travis-ci.org/AndyWendt/spam-canner) [![Coverage Status](https://coveralls.io/repos/AndyWendt/spam-canner/badge.png?branch=master)](https://coveralls.io/r/AndyWendt/spam-canner?branch=master)

Extensible Spam Detection Filters.

## Usage

Filters are located in the `src/Filters` directory.
You can add your own filters as well, they just need to implement `CmdZ\SpamCanner\Filters\FilterInterface` and then add them
to the `$filters` array that you pass to `Score()`

```php

$increase = 1;
$filters = [
    new \CmdZ\SpamCanner\Filters\BodyInPreviousComment('abcd', $increase, 'abcd'),
    new \CmdZ\SpamCanner\Filters\Tlds($increase, 'http://test.de', ['de'], new \CmdZ\SpamCanner\Utilities\DomainParser())
];

$score = new \CmdZ\SpamCanner\Score($filters, new \CmdZ\SpamCanner\Utilities\Utilities());
$result = $score->getScore();


```


## Testing

``` bash
$ phpunit
```



## License

The MIT License (MIT). Please see the License File for more information.
