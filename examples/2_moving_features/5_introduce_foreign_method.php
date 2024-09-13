<?php

class WrongExampleIntroduceForeignMethod {
    private DateTime $previousDate;

    public function __construct()
    {
        $this->previousDate = new DateTime();
    }

    public function sendReport() {
        $previousDate = clone $this->previousDate;
        $paymentDate = $previousDate->modify("+7 days");
        echo "Sending report on: " . $paymentDate->format('Y-m-d') . PHP_EOL;
    }
}

class GoodExampleIntroduceForeignMethod {
    private DateTime $previousDate;

    public function __construct()
    {
        $this->previousDate = new DateTime();
    }

    public function sendReport() {
        $paymentDate = self::nextWeek($this->previousDate);
        echo "Sending report on: " . $paymentDate->format('Y-m-d') . PHP_EOL;
    }

    private static function nextWeek(DateTime $arg) {
        $previousDate = clone $arg;
        return $previousDate->modify("+7 days");
    }
}

$wrongExample = new WrongExampleIntroduceForeignMethod();
$wrongExample->sendReport();

$goodExample = new GoodExampleIntroduceForeignMethod();
$goodExample->sendReport();