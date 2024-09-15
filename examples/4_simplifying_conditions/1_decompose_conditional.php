<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Carbon\CarbonInterface;

$date = now();
define('SUMMER_START', date('Y-06-01'));
define('SUMMER_END', date('Y-08-31'));
const SUMMER_RATE = 8;
const WINTER_RATE = 10;
const WINTER_SERVICE_CHARGE = 5;

function wrongExampleCalculate(CarbonInterface $date, int $quantity): float {
    if ($date->isBefore(SUMMER_START) ||
        $date->isAfter(SUMMER_END)
    ) {
        $charge = $quantity * WINTER_RATE + WINTER_SERVICE_CHARGE;
    } else {
        $charge = $quantity * SUMMER_RATE;
    }
    return $charge;
}


function isWinter(CarbonInterface $date): bool {
    return $date->isBefore(SUMMER_START) || $date->isAfter(SUMMER_END);
}

function summerCharge(int $quantity): float
{
    return $quantity * SUMMER_RATE;
}

function winterCharge(int $quantity): float
{
    return $quantity * WINTER_RATE + WINTER_SERVICE_CHARGE;
}


function goodExampleCalculate(CarbonInterface $date, int $quantity): float {

    if (isWinter($date)) {
        $charge = winterCharge($quantity);
    } else {
        $charge = summerCharge($quantity);
    }

    return $charge;
}

function betterExampleCalculate(CarbonInterface $date, int $quantity): float {
    return isWinter($date) ? winterCharge($quantity) : summerCharge($quantity);
}

// Użycie:
var_dump(wrongExampleCalculate($date, 5)); // Wynik: 40
var_dump(goodExampleCalculate($date, 5)); // Wynik: 40
var_dump(betterExampleCalculate($date, 5)); // Wynik: 40