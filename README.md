# Spam Canner


## Usage

Filters are located in the `src/Filters` directory.
You can add your own filters as well, they just need to implement `CmdZ\SpamCanner\Filters\FilterInterface` and then add them
to the `$filters` array that you pass to `Score()`

```php

$increase = 1;
$filters = [
    new BodyInPreviousComment('abcd', $increase, 'abcd'),
    new Tlds($increase, 'http://test.de', ['de'], new DomainParser())
];

$score = new Score($filters, new Utilities());
$result = $score->getScore();


```


## Testing

``` bash
$ phpunit
```



## License

The MIT License (MIT). Please see the License File for more information.
