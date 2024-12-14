<?php

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

define('LEN', strpos($data, PHP_EOL));

$sum = 0;

$patterns = array(
    'up'    => '/#((?<begin>.{10})\.(?<middle>(.{10}\.)*)(?<end>.{10})|(?<single>.{10}))\^/ms',
    'right' => '/>(.*?)#/ms',
);

function goUpCallback(array $matches): string
{
    for ($i = LEN; $i < strlen($matches['middle']); $i += LEN + 1) {
        $matches['middle'][$i] = 'X';
    }

    return '#' . $matches['begin'] . ($matches['single'] ?: '') . '>' . $matches['middle'] . $matches['end'] . 'X';
}

function goUp(): bool
{
    global $data, $patterns;

    $count = 0;

    $data = preg_replace_callback($patterns['up'], 'goUpCallback', $data, -1, $count);

    return $count > 0;
}

function goRightCallback(array $matches): string
{
    return str_repeat('X', strlen($matches[1])) . '∨#';
}

function goRight(): bool
{
    global $data, $patterns;

    $count = 0;

    $data = preg_replace_callback($patterns['right'], 'goRightCallback', $data, -1, $count);

    return $count > 0;
}


$pattrnUp = '/#((?<begin>.{10})\.(?<middle>(.{10}\.)*)(?<end>.{10})|(?<single>.{10}))\^/ms';

$replaceUp = '#$begin$single>$middle$end.';

echo $len . PHP_EOL;

echo $data . PHP_EOL;

$result = goUp();

echo $data . PHP_EOL;

$result = goRight();

echo $data . PHP_EOL;

var_dump($result);

echo $sum . PHP_EOL;

?>
