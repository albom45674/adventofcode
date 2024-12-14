<?php

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$len = strpos($data, PHP_EOL) + 1;

$sum = 0;


$pattern = '/(?=(M.M.{LEN}A.{LEN}S.S))|(?=(M.S.{LEN}A.{LEN}M.S))|(?=(S.M.{LEN}A.{LEN}S.M))|(?=(S.S.{LEN}A.{LEN}M.M))/ms';
$pattern = str_replace('LEN', $len - 2, $pattern);

//echo $pattern;

$sum += preg_match_all($pattern, $data);

echo $sum . PHP_EOL;

?>
