<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product as ProductModel;
use App\ProductService;
use App\ValueObjects\Product;
use Illuminate\Http\Request;

class ProductManagementController extends Controller
{
    // Metoda do dodawania nowego produktu
    public function addProduct(CreateProductRequest $request)
    {
        $product = $this->createProduct($request->getProduct());

        return response()->json([
            'message' => 'Product added successfully',
            'product' => $product,
        ]);
    }

    // Metoda do aktualizacji istniejącego produktu
    public function updateProduct(UpdateProductRequest $request, ProductModel $product)
    {
        $this->updateProductDetails($product, $request->getProduct());

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product,
        ]);
    }

    // Metoda do usuwania produktu
    public function deleteProduct($id)
    {
        $product = ProductModel::find($id);

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
        $product = ProductModel::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'product' => $product,
        ]);
    }

    // Metoda do tworzenia produktu
    private function createProduct(Product $product)
    {
        $model = new ProductModel($product->toArray());
        $model->save();
        return $model;
    }

    // Metoda do aktualizacji szczegółów produktu
    private function updateProductDetails(ProductModel $entity, Product $product)
    {
        $entity->update($product->toArray());
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
