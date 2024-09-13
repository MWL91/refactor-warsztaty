<?php

class WrongExampleRemoveAssignmentsToParameters
{
    public function __invoke(int $inputVal, int $quantity): int
    {
        if ($quantity > 50) {
            $inputVal -= 2;
        }

        return $inputVal;
    }
}

class GoodExampleRemoveAssignmentsToParameters
{
    public function __invoke(int $inputVal, int $quantity): int
    {
        $result = $inputVal; // When $inputVal would be class we should clone it!
        if ($quantity > 50) {
            $result -= 2;
        }

        return $result;
    }
}

$wrongExample = new WrongExampleRemoveAssignmentsToParameters();
echo $wrongExample(10, 100);

echo PHP_EOL;

$goodExample = new GoodExampleRemoveAssignmentsToParameters();
echo $goodExample(10, 100);