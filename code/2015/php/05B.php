<?php

$fo = fopen('php://stdin', 'r');

$sum = 0;

while (false !== ($line = fgets($fo))) {

    if (empty($line)) {
        continue;
    }

    $line = trim($line);

    preg_match('/(\w).\1/', $line, $match);

    $nice = !empty($match[0]);   
 
    preg_match('/(\w{2}).*\1/', $line, $match);

    $nice = $nice && !empty($match[0]);

    echo $line . '   ' . ($nice ? 'NICE' : 'NAUGHTY') . PHP_EOL;

    if ($nice) {
        $sum++;
    }
}

echo $sum . PHP_EOL;

?>
