<?php

$fo = fopen('php://stdin', 'r');

$rules = array();
$list = array();

$patterns = array();

$sum = 0;

function rule_sort(int $a, int $b): int
{
    global $rules;

    $result = 0;

    foreach ($rules as $rule) {
        if ($rule[0] == $a && $rule[1] == $b) {
            $result = -1;
        } elseif ($rule[1] == $a && $rule[0] == $b) {
            $result = 1;
        }
    }

    return $result;
}

while (false !== ($line = fgets($fo))) {

    $line = trim($line);

    if (empty($line)) {
        continue;
    }

    if (false !== strpos($line, '|')) {
        list($left, $right) = explode('|', $line);
        $rules[] = array((int)$left, (int)$right);
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

    $list = explode(',', $line);
    $ind = floor(count($list) / 2);

    if (!$good) {
        usort($list, 'rule_sort');
        echo implode(',', $list) . PHP_EOL;

        $sum += $list[$ind];
    }
}

echo $sum . PHP_EOL;

?>
