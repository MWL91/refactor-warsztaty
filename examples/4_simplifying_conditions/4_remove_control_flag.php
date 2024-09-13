<?php

function wrongExampleRemoveControlFlag(array $people): bool
{
    $found = false;
    foreach ($people as $person) {
        if (!$found) {
            if ($person === "Don") {
                $found = true;
            }
            if ($person === "John") {
                $found = true;
            }
        }
    }

    return $found;
}

function goodExampleRemoveControlFlag(array $people): bool
{
    foreach ($people as $person) {
        if ($person === "Don" || $person === "John") {
            return true;
        }
    }

    return false;
}

// Użycie
$people = ["Alice", "Bob", "Don"];
var_dump(wrongExampleRemoveControlFlag($people)); // Wynik: true
var_dump(goodExampleRemoveControlFlag($people)); // Wynik: true