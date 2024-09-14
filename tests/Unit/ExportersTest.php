<?php

namespace Tests\Unit;

use App\Exporters\Export;
use App\Exporters\JsonExporter;
use PHPUnit\Framework\TestCase;
use App\Exporters\CsvExporter;

class ExportersTest extends TestCase
{
    public static function exportersDataProvider(): array
    {
        return [
            'CsvExporter' => [new CsvExporter(), "Product Name,Price\nProduct 1,100\nProduct 2,200\n"],
            'JsonExporter' => [new JsonExporter(), '[{"name":"Product 1","price":100},{"name":"Product 2","price":200}]'],
        ];
    }

    /** @dataProvider exportersDataProvider */
    public function test_export(Export $exporter, string $expected): void
    {
        $products = [
            ['name' => 'Product 1', 'price' => 100],
            ['name' => 'Product 2', 'price' => 200],
        ];

        $this->assertEquals($expected, $exporter->export($products));
    }
}
