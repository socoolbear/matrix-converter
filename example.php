<?php
require __DIR__ . '/vendor/autoload.php';

$jconv = new SpecConverter\JsonConverter();
$jcor = $jconv->toMatrix("a\tb\r\nc\td");

$tconv = new SpecConverter\TabConverter();
$tcor = $tconv->toMatrix($jcor);

echo 'json converter : ' . $jcor . PHP_EOL;
echo 'tab converter : ' . $tcor . PHP_EOL;
