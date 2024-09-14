<?php

namespace App\Exporters;

class JsonExporter implements Export
{
    public function export(array $products): string
    {
        // Logika eksportu produktów do formatu JSON
        return json_encode($products);
    }
}
