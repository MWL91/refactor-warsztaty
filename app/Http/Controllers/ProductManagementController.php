<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\ProductService;
use Illuminate\Http\Request;

class ProductManagementController extends Controller
{
    // Metoda do dodawania nowego produktu
    public function addProduct(Request $request)
    {
        $productName = $request->input('name'); // string
        $productPrice = $request->input('price'); // float
        $productStock = $request->input('stock'); // int
        $productTags = $request->input('tags'); // array (tagi produktu)

        $this->validateProductData($productName, $productPrice, $productStock);

        $product = $this->createProduct($productName, $productPrice, $productStock, $productTags);

        return response()->json([
            'message' => 'Product added successfully',
            'product' => $product,
        ]);
    }

    // Metoda do aktualizacji istniejącego produktu
    public function updateProduct(Request $request, $id)
    {
        $productName = $request->input('name'); // string
        $productPrice = $request->input('price'); // float
        $productStock = $request->input('stock'); // int
        $productTags = $request->input('tags'); // array (tagi produktu)

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $this->validateProductData($productName, $productPrice, $productStock);

        $this->updateProductDetails($product, $productName, $productPrice, $productStock, $productTags);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product,
        ]);
    }

    // Metoda do usuwania produktu
    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $this->removeProduct($product);

        return response()->json([
            'message' => 'Product deleted successfully',
        ]);
    }

    // Metoda do wyświetlania szczegółów produktu
    public function getProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'product' => $product,
        ]);
    }

    // Metoda do walidacji danych produktu
    private function validateProductData($name, $price, $stock)
    {
        if (!$name || $price <= 0 || $stock < 0) {
            throw new \InvalidArgumentException('Invalid product data');
        }
    }

    // Metoda do tworzenia produktu
    private function createProduct($name, $price, $stock, $tags)
    {
        $product = new Product();
        $product->name = $name;
        $product->price = $price;
        $product->stock = $stock;
        $product->tags = json_encode($tags); // Zapisujemy tagi jako JSON
        $product->save();

        return $product;
    }

    // Metoda do aktualizacji szczegółów produktu
    private function updateProductDetails($product, $name, $price, $stock, $tags)
    {
        if ($name) $product->name = $name;
        if ($price) $product->price = $price;
        if ($stock) $product->stock = $stock;
        if ($tags) $product->tags = json_encode($tags); // Zapisujemy tagi jako JSON

        $product->save();
    }

    // Metoda do usuwania produktu
    private function removeProduct($product)
    {
        $product->delete();
    }

    public function createOrUpdateProduct(
        Request $request,
    ) {
        $service = new ProductService();
        $p = $service->cou(
            $request->input('id'),
            $request->input('name'),
            $request->input('price'),
            $request->input('stock'),
            $request->input('tags'),
            $request->input('description'),
            $request->input('category'),
            $request->input('manufacturer'),
            $request->input('sku'),
            $request->input('weight'),
            $request->input('dimensions'),
            $request->input('color'),
            $request->input('size'),
            $request->input('material'),
            $request->input('warranty')
        );

        return response()->json([
            'message' => $request->input('id') ? 'Product updated successfully' : 'Product created successfully',
            'product' => $p,
        ]);
    }
}
