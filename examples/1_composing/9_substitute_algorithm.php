<?php

function wrongExampleSubstituteAlgorithm(array $people): string
{
    for ($i = 0; $i < count($people); $i++) {
        if ($people[$i] === "Marek") {
            return "Marek";
        }
        if ($people[$i] === "Marysia") {
            return "Marysia";
        }
        if ($people[$i] === "Wojtek") {
            return "Wojtek";
        }
    }
    return "";
}

function goodExampleSubstituteAlgorithm(array $people): string
{
    foreach (["Marek", "Marysia", "Wojtek"] as $needle) {
        $id = array_search($needle, $people, true);
        if ($id !== false) {
            return $people[$id];
        }
    }
    return "";
}

$people = ["Don", "John", "Kent", "Marek", "Marysia", "Wojtek"];
echo wrongExampleSubstituteAlgorithm($people) . PHP_EOL;
echo goodExampleSubstituteAlgorithm($people) . PHP_EOL;