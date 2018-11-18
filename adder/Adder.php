<?php

class Adder
{
    /**
     * @param string $number1
     * @param string $number2
     * @return string
     */
    public function add(string $number1, string $number2)
    {
        // Do column addition

        // Pad them
        $maxLength = max(strlen($number1), strlen($number2));
        $number1 = str_pad($number1, $maxLength, '0', STR_PAD_LEFT);
        $number2 = str_pad($number2, $maxLength, '0', STR_PAD_LEFT);

        $result = '';
        $remain = 0;

        for ($position = $maxLength - 1; $position >= 0; $position -= 1) {
            $digit1 = $number1[$position];
            $digit2 = $number2[$position];
            $sum = (int) $digit1 + (int) $digit2 + $remain;
            $resultDigit = $sum % 10;
            $remain = floor($sum / 10);
            $result = ((string) $resultDigit) . $result;
        }

        if ($remain) {
            $result = ((string) $remain) . $result;
        }

        return $result;
    }
}