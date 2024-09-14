<?php
declare(strict_types=1);

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

class Product implements Arrayable
{
    public function __construct(
        protected string $name,
        protected float  $cena,
        protected int    $stock,
        protected ?array $tags = null,
    )
    {
        if ($name === '' || $cena <= 0 || $stock < 0) {
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
            'price' => $this->cena,
            'stock' => $this->stock,
            'tags' => $this->tags,
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCena(): float
    {
        return $this->cena;
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