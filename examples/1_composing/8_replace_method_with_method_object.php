<?php

class WrongExampleReplaceMethodWithMethodObject {
    // ...
    public function price(): float {
        $primaryBasePrice = 10;
        $secondaryBasePrice = 20;
        $tertiaryBasePrice = 30;
        // Perform long computation.

        return $primaryBasePrice + $secondaryBasePrice + ($tertiaryBasePrice * 0.8);
    }
}

////////////////////////////////////////////////////////////////////////////////

class GoodExampleReplaceMethodWithMethodObject {
    public function price(): float {
        return (new PriceCalculator(
            $primaryBasePrice = 10,
            $secondaryBasePrice = 20,
            $tertiaryBasePrice = 30,
        ))->compute();
    }
}

class PriceCalculator {
    public function __construct(
        private int $primaryBasePrice,
        private int $secondaryBasePrice,
        private int $tertiaryBasePrice,
    ) {
    }

    public function compute(): float {
        return $this->primaryBasePrice + $this->secondaryBasePrice + ($this->tertiaryBasePrice * 0.8);
    }
}

//

$wrongExample = new WrongExampleReplaceMethodWithMethodObject();
echo $wrongExample->price() . PHP_EOL;

$goodExample = new GoodExampleReplaceMethodWithMethodObject();
echo $goodExample->price() . PHP_EOL;