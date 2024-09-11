<?php

namespace App\Exporters;

class JsonExporter
{
    public function convertToJson($products)
    {
        // Logika eksportu produktów do formatu JSON
        return json_encode($products);
    }
}
