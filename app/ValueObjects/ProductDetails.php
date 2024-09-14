<?php

namespace App\ValueObjects;

class ProductDetails extends Product
{
    public function __construct(
        string $name,
        float $price,
        int $stock,
        ?array $tags = null,
        private ?string $description,
        private ?Category $category,
        private ?Manufacturer $manufacturer,
        private ?Sku $sku,
        private ?Size $size,
        private ?Appearance $appearance,
        private ?Warranty $warranty,
    )
    {
        parent::__construct($name, $price, $stock, $tags);
    }

    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            'description' => $this->description,
            'category' => (string) $this->category,
            'manufacturer' => (string) $this->manufacturer,
            'sku' => (string) $this->sku,
            ...$this->size?->toArray(),
            ...$this->appearance?->toArray(),
            'warranty' => (string) $this->warranty?->toArray(),
        ];
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function getSku(): ?Sku
    {
        return $this->sku;
    }

    public function getSize(): ?Size
    {
        return $this->size;
    }

    public function getAppearance(): ?Appearance
    {
        return $this->appearance;
    }

    public function getWarranty(): ?Warranty
    {
        return $this->warranty;
    }
}