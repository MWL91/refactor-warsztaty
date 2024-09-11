<?php

namespace Tests\Unit;

use App\Exporters\JsonExporter;
use PHPUnit\Framework\TestCase;
use App\Exporters\CsvExporter;

class ExportersTest extends TestCase
{
    public function test_export_to_csv()
    {
        // Przygotuj przykładowe produkty
        $products = [
            ['name' => 'Product 1', 'price' => 100],
            ['name' => 'Product 2', 'price' => 200],
        ];

        // Utwórz obiekt klasy CsvExporter
        $csvExporter = new CsvExporter();

        // Oczekiwany rezultat
        $expectedCsv = "Product Name,Price\nProduct 1,100\nProduct 2,200\n";

        // Wywołaj metodę exportToCsv i porównaj wynik
        $this->assertEquals($expectedCsv, $csvExporter->exportToCsv($products));
    }

    public function test_convert_to_json()
    {
        // Przygotuj przykładowe produkty
        $products = [
            ['name' => 'Product 1', 'price' => 100],
            ['name' => 'Product 2', 'price' => 200],
        ];

        // Utwórz obiekt klasy JsonExporter
        $jsonExporter = new JsonExporter();

        // Oczekiwany rezultat
        $expectedJson = json_encode($products);

        // Wywołaj metodę convertToJson i porównaj wynik
        $this->assertEquals($expectedJson, $jsonExporter->convertToJson($products));
    }
}
