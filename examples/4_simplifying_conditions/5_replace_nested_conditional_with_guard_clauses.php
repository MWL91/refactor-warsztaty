<?php

readonly class PersonalRelation
{
    public function __construct(
        private bool $isDead,
        private bool $isSeparated,
        private bool $isRetired
    )
    {
    }

    public function wrongExampleReplaceNestedConditionalWithGuardClauses(): float
    {
        if ($this->isDead) {
            $result = $this->deadAmount();
        } else {
            if ($this->isSeparated) {
                $result = $this->separatedAmount();
            } else {
                if ($this->isRetired) {
                    $result = $this->retiredAmount();
                } else {
                    $result = $this->normalPayAmount();
                }
            }
        }
        return $result;
    }

    public function goodExampleReplaceNestedConditionalWithGuardClauses(): float
    {
        if ($this->isDead) {
            return $this->deadAmount();
        }

        if ($this->isSeparated) {
            return $this->separatedAmount();
        }

        if ($this->isRetired) {
            return $this->retiredAmount();
        }

        return $this->normalPayAmount();
    }

    private function deadAmount(): float
    {
        return 0;
    }

    private function separatedAmount(): float
    {
        return 50;
    }

    private function retiredAmount(): float
    {
        return 10;
    }

    private function normalPayAmount(): float
    {
        return 100;
    }
}

$personalRelation = new PersonalRelation(false, true, false);
echo $personalRelation->wrongExampleReplaceNestedConditionalWithGuardClauses() . "\n"; // Wynik: 50
echo $personalRelation->goodExampleReplaceNestedConditionalWithGuardClauses() . "\n"; // Wynik: 50