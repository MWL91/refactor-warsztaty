<?php
declare(strict_types=1);

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

class Product implements Arrayable
{
    public function __construct(
        private string $name,
        private float $price,
        private int $stock,
        private ?array $tags = null,
    )
    {
        if ($name === '' || $price <= 0 || $stock < 0) {
            throw new \InvalidArgumentException('Invalid product data');
        }
    }

    public static function fromArray(array $array): self
    {
        return new self(
            $array['name'],
            $array['price'],
            $array['stock'],
            $array['tags'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'tags' => $this->tags,
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }
}