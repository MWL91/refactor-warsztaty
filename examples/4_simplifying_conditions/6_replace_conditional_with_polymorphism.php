<?php

abstract class Bird {
    public function __construct(
        protected string $type,
        protected int $numberOfCoconuts,
        protected bool $isNailed,
        protected int $voltage
    )
    {
    }

    abstract function getSpeed(): int;

    protected function getBaseSpeed(): int
    {
        return 42;
    }

    protected function getLoadFactor(): int
    {
        return 2;
    }
}

class WrongExampleReplaceConditionalWithPolymorphism extends Bird {
    public function getSpeed(): int
    {
        switch ($this->type) {
            case 'EUROPEAN':
                return $this->getBaseSpeed();
            case 'AFRICAN':
                return $this->getBaseSpeed() - $this->getLoadFactor() * $this->numberOfCoconuts;
            case 'NORWEGIAN_BLUE':
                return ($this->isNailed) ? 0 : $this->getBaseSpeed() * $this->voltage;
        }
        throw new Exception("Should be unreachable");
    }
}

class European extends Bird {
    public function __construct(int $numberOfCoconuts, bool $isNailed, int $voltage)
    {
        parent::__construct('EUROPEAN', $numberOfCoconuts, $isNailed, $voltage);
    }

    public function getSpeed(): int {
        return $this->getBaseSpeed();
    }
}
class African extends Bird {
    public function getSpeed(): int {
        return $this->getBaseSpeed() - $this->getLoadFactor() * $this->numberOfCoconuts;
    }
}
class NorwegianBlue extends Bird {
    public function getSpeed(): int {
        return ($this->isNailed) ? 0 : $this->getBaseSpeed() * $this->voltage;
    }
}

// Użycie
$wrongExample = new WrongExampleReplaceConditionalWithPolymorphism('EUROPEAN', 0, false, 0);
echo $wrongExample->getSpeed() . "\n"; // Wynik: 42

$european = new European('EUROPEAN', 0, false, 0);
echo $european->getSpeed() . "\n"; // Wynik: 42