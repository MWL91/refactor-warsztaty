<?php

namespace App\Exporters;

class CsvExporter
{
    public function exportToCsv($products)
    {
        // Logika eksportu produktów do formatu CSV
        $csv = "Product Name,Price\n";
        foreach ($products as $product) {
            $csv .= "{$product['name']},{$product['price']}\n";
        }
        return $csv;
    }
}
