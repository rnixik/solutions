<?php

require_once 'Adder.php';
$adder = new Adder();

$testCases = [
    ['123', '456', '579'],
    ['123', '459', '582'],
    ['1', '789', '790'],
    ['654', '3', '657'],
    ['45171761576165176517651765167875', '46765297916172279997849446441418', '91937059492337456515501211609293'],
    ['0', '0', '0'],
    ['999', '1', '1000'],
    ['999', '0', '999'],
    ['0', '999', '999'],
    ['a', '999', '999'],
    ['999', 'a', '999'],
];

$errorDetails = [];

foreach ($testCases as $testCase) {
    $sum = $adder->add($testCase[0], $testCase[1]);
    if ($sum == $testCase[2]) {
        echo '.';
    } else {
        echo 'E';
        $errorDetails[] = "expected $testCase[2] != actual $sum  = $testCase[0] + $testCase[1]";
    }
}

echo PHP_EOL;

foreach ($errorDetails as $detail) {
    echo $detail . PHP_EOL;
}

if (empty($errorDetails)) {
    echo "Success" . PHP_EOL;
} else {
    echo 'Failure' . PHP_EOL;
    exit(1);
}
