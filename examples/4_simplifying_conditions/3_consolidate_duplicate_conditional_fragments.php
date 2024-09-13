<?php

function isSpecialDeal(): bool
{
    return true;
}

function send(): void
{
    echo "Send\n";
}

function wrongExampleReplaceMagicNumberWithSymbolicConstant(float $price): void
{
    if (isSpecialDeal()) {
        $total = $price * 0.95;
        send();
    } else {
        $total = $price * 0.98;
        send();
    }

    echo $total . "\n";
}

function goodExampleReplaceMagicNumberWithSymbolicConstant(float $price): void
{
    $total = $price * (isSpecialDeal() ? 0.95 : 0.98);
    send();

    echo $total . "\n";
}

// Użycie
wrongExampleReplaceMagicNumberWithSymbolicConstant(100);
goodExampleReplaceMagicNumberWithSymbolicConstant(100);