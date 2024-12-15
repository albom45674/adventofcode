<?php

$fo = fopen('php://stdin', 'r');

$sum = 0;

while (false !== ($line = fgets($fo))) {

    if (empty($line)) {
        continue;
    }

    $line = trim($line);

    preg_match_all('/(?<vowel>[aeiou])/', $line, $match);

    $nice = count(array_filter($match['vowel'])) >= 3;   
 
    preg_match_all('/(?<double>aa|bb|cc|dd|ee|ff|gg|hh|ii|jj|kk|ll|mm|nn|oo|pp|qq|rr|ss|tt|uu|vv|ww|xx|yy|zz)/', $line, $match);
    
    $nice = $nice && count(array_filter($match['double']));

    preg_match_all('/(?<bad>ab|cd|pq|xy)/', $line, $match);

    $nice = $nice && empty(array_filter($match['bad']));

    echo $line . '   ' . ($nice ? 'NICE' : 'NAUGHTY') . PHP_EOL;

    if ($nice) {
        $sum++;
    }
}

echo $sum . PHP_EOL;

?>
