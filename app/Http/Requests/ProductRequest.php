<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\ValueObjects\Product;
use Illuminate\Foundation\Http\FormRequest;

abstract class ProductRequest extends FormRequest
{
    public function getProduct(): Product
    {
        return new Product(
            $this->input('name'),
            $this->input('price'),
            $this->input('stock'),
            $this->input('tags')
        );
    }
}