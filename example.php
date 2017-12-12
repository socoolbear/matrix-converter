<?php
require __DIR__ . '/vendor/autoload.php';

$jconv = new MatrixConverter\JsonConverter();
$jcor = $jconv->toMatrix("a\tb\r\nc\td");

$tconv = new MatrixConverter\TabConverter();
$tcor = $tconv->toMatrix($jcor);

echo 'json converter : ' . $jcor . PHP_EOL;
echo 'tab converter : ' . $tcor . PHP_EOL;
