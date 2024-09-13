<?php

class WrongExampleReplaceMagicNumberWithSymbolicConstant
{
    public function getHoursFromUnixTimeStart(): int
    {
        return ceil(time() / 60);
    }
}

class GoodExampleReplaceMagicNumberWithSymbolicConstant
{
    private const int MINUTES_IN_HOUR = 60;

    public function getHoursFromUnixTimeStart(): int
    {
        return ceil(time() / self::MINUTES_IN_HOUR);
    }
}

$wrongExample = new WrongExampleReplaceMagicNumberWithSymbolicConstant();
echo $wrongExample->getHoursFromUnixTimeStart() . "\n"; // Wynik: 1
$goodExample = new GoodExampleReplaceMagicNumberWithSymbolicConstant();
echo $goodExample->getHoursFromUnixTimeStart() . "\n"; // Wynik: 1