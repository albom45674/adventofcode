<?php

$fo = fopen('php://stdin', 'r');

$count = 0;

while (false !== ($line = fgets($fo))) {

    if (empty($line)) {
        continue;
    }

    $list = explode(' ', $line);
    $list = array_map('intval', $list);

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

    if ($good) {
        $count++;
        echo $line;
    }
}

echo $count . PHP_EOL;

?>
