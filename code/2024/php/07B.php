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

    for ($s = 0; $s < 3**$pow; $s++) {
        $seq = str_pad(base_convert($s, 10, 3), $pow, '0', STR_PAD_LEFT);
        $sum = $list[0];

        $expr = $list[0];
        for ($i = 0; $i < $pow; $i++) {
            if ('0' == $seq[$i]) {
                $expr .= ' + ';
                $sum += $list[$i + 1];
            } elseif ('1' == $seq[$i]) {
                $expr .= ' * ';
                $sum *= $list[$i + 1];
            } else {
                $sum = (int)((string)$sum . (string)$list[$i + 1]);
            }
            $expr .= $list[$i + 1];
        }

//        echo $value . ':  ' . $s . ' ' .  $seq . '     ' .  $expr . ' = ' . $sum . PHP_EOL;

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
