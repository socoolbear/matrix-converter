Matrix Converter
==============
Tab Or Json spereated Matrix String Converter

Getting started
----------------
```
composer require scoolbear/matrix-converter
```

Example
-------
```
<?php
require __DIR__ . '/vendor/autoload.php';

$jconv = new SpecConverter\JsonConverter();
$jcor = $jconv->toMatrix("a\tb\r\nc\td");

$tconv = new SpecConverter\TabConverter();
$tcor = $tconv->toMatrix($jcor);

echo 'json converter : ' . $jcor . PHP_EOL;
echo 'tab converter : ' . $tcor . PHP_EOL;
```
```
json converter : 
{
  "count": {
    "trados": 0
  },
  "data": [
    [
      {
        "from": "seo.translate_dictionary_source",
        "keyword": "a",
        "result": "a",
        "type": "head"
      },
      {
        "from": "seo.translate_dictionary_source",
        "keyword": "b\r",
        "result": "b\r",
        "type": "head"
      }
    ],
    [
      {
        "from": "seo.translate_dictionary_source",
        "keyword": "c",
        "result": "c",
        "type": "body"
      },
      {
        "from": "seo.translate_dictionary_source",
        "keyword": "d",
        "result": "d",
        "type": "body"
      }
    ]
  ]
}
```
```
tab converter :
a       b
c       d
```
