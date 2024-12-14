<?php

function check_list(array $list): bool
{
    $good = true;

    $inc = $list[1] - $list[0];

    for ($i = 1; $i < count($list); $i++) {
        $diff = $list[$i] - $list[$i-1];
        if (0 == abs($diff) || 3 < abs($diff)) {
            $good = false;
        } elseif ($inc * $diff < 0) {
            $good = false;
        }

        if (!$good) {
            break;
        }
    }

    return $good;
}

function unset_list(array $list, int $ind): array
{
    unset($list[$ind]);
    return array_values($list);
}

$fo = fopen('php://stdin', 'r');

$count = 0;

while (false !== ($line = fgets($fo))) {

    if (empty($line)) {
        continue;
    }

    $list = explode(' ', $line);
    $list = array_map('intval', $list);

    $good = check_list($list);

    for ($i = 0; $i < count($list); $i++) {
        $ulist = unset_list($list, $i);
        $good = -1 == check_list($ulist);
        if ($good) {
            break;
        }
    }

    if ($good) {
        $count++;
        echo $line;
    }
}

echo $count . PHP_EOL;

?>
