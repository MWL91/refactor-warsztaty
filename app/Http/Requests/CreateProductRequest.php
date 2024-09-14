<?php
declare(strict_types=1);

namespace App\Http\Requests;

class CreateProductRequest extends ProductRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'tags' => 'array|nullable',
        ];
    }
}