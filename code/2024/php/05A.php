<?php

$fo = fopen('php://stdin', 'r');


$rules = array();
$list = array();

$patterns = array();

$sum = 0;

while (false !== ($line = fgets($fo))) {

    $line = trim($line);

    if (empty($line)) {
        continue;
    }

    if (false !== strpos($line, '|')) {
        list($left, $right) = explode('|', $line);
        $patterns[] = sprintf('/%s.*%s/', $right, $left);
    }

    if (false === strpos($line, ',')) {
        continue;
    }

    $good = true;

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $line, $match)) {
            $good = false;
            break;
        }
    }

    if ($good) {
        $list = explode(',', $line);
        $ind = floor(count($list) / 2);
        $sum += $list[$ind];
    }

    echo $line . ' ' . ($good ? 'good' : 'bad') . ' ' . ($good ? '[' . $ind . '] = ' . $list[$ind] : '') . PHP_EOL;
}

echo $sum . PHP_EOL;

?>
