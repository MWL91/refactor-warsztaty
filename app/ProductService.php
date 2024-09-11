<?php

namespace App;

use App\Models\Product;

class ProductService
{

    public function __construct()
    {
    }

    public function cou(
        $id = null,
        $name = null,
        $price = null,
        $stock = null,
        $tags = null,
        $description = null,
        $category = null,
        $manufacturer = null,
        $sku = null,
        $weight = null,
        $dimensions = null,
        $color = null,
        $size = null,
        $material = null,
        $warranty = null
    ): Product
    {
        if ($id) {
            $product = Product::find($id);

            if (!$product) {
                throw new \Exception("Product not found");
            }
        } else {
            $product = new Product();
        }

        if ($name) $product->name = $name;
        if ($price) $product->price = $price;
        if ($stock) $product->stock = $stock;
        if ($tags) $product->tags = json_encode($tags);
        if ($description) $product->description = $description;
        if ($category) $product->category = $category;
        if ($manufacturer) $product->manufacturer = $manufacturer;
        if ($sku) $product->sku = $sku;
        if ($weight) $product->weight = $weight;
        if ($dimensions) $product->dimensions = $dimensions;
        if ($color) $product->color = $color;
        if ($size) $product->size = $size;
        if ($material) $product->material = $material;
        if ($warranty) $product->warranty = $warranty;

        $product->save();
        return $product;
    }
}