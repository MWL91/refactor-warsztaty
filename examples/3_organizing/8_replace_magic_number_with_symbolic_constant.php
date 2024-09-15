<?php

class WrongExampleReplaceMagicNumberWithSymbolicConstant
{
    public function getHoursFromUnixTimeStart(): int
    {
        return ceil(time() / 3600);
    }
}

class GoodExampleReplaceMagicNumberWithSymbolicConstant
{
    private const int SECONDS_IN_HOUR = 3600;

    public function getHoursFromUnixTimeStart(): int
    {
        return ceil(time() / self::SECONDS_IN_HOUR);
    }
}

$wrongExample = new WrongExampleReplaceMagicNumberWithSymbolicConstant();
echo $wrongExample->getHoursFromUnixTimeStart() . "\n"; // Wynik: 1
$goodExample = new GoodExampleReplaceMagicNumberWithSymbolicConstant();
echo $goodExample->getHoursFromUnixTimeStart() . "\n"; // Wynik: 1