<?php

$fo = fopen('php://stdin', 'r');

$count = 0;

while (false !== ($line = fgets($fo))) {

    if (empty($line)) {
        continue;
    }

    list($value, $list) = explode(': ', $line);

    $list = explode(' ', $list);
    $list = array_map('intval', $list);
    $value = (int)$value;

    $good = false;

    $pow = count($list) - 1; 

    for ($s = 0; $s < 2**$pow; $s++) {
        $seq = str_pad(decbin($s), $pow, '0', STR_PAD_LEFT);
        $sum = $list[0];
        for ($i = 0; $i < $pow; $i++) {
            if ('0' == $seq[$i]) {
                $sum += $list[$i + 1];
            } else {
                $sum *= $list[$i + 1];
            }
        }

        if ($sum == $value) {
            $good = true;
            break;
        }
    }

    
    if ($good) {
        $count += $value;
        echo $line;
    }
}

echo $count . PHP_EOL;

?>
