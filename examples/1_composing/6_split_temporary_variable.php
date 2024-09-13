<?php

class WrongExampleSplitTemporaryVariable
{
    public function __construct(
        private int $height = 10,
        private int $width = 20
    )
    {
    }

    public function printSizes(): void
    {
        $temp = 2 * ($this->height + $this->width);
        echo $temp;
        $temp = $this->height * $this->width;
        echo $temp;
    }
}

class GoodExampleSplitTemporaryVariable
{
    public function __construct(
        private int $height = 10,
        private int $width = 20
    )
    {
    }

    public function printSizes(): void
    {
        $perimeter = 2 * ($this->height + $this->width);
        echo $perimeter;
        $area = $this->height * $this->width;
        echo $area;
    }
}

class BetterExampleSplitTemporaryVariable
{
    public function __construct(
        private int $height = 10,
        private int $width = 20
    )
    {
    }

    public function printSizes(): void
    {
        echo $this->getPerimeter();
        echo $this->getArea();
    }

    public function getPerimeter(): float
    {
        return 2 * ($this->height + $this->width);
    }

    public function getArea(): float
    {
        return $this->height * $this->width;
    }
}

// Wrong:
$wrongExample = new WrongExampleSplitTemporaryVariable();
$wrongExample->printSizes();
echo PHP_EOL;

// Good:
$goodExample = new GoodExampleSplitTemporaryVariable();
$goodExample->printSizes();
echo PHP_EOL;

// Better:
$betterExample = new BetterExampleSplitTemporaryVariable();
$betterExample->printSizes();
echo PHP_EOL;
