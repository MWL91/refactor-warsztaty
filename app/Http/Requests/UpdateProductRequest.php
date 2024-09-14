<?php
declare(strict_types=1);

namespace App\Http\Requests;

class UpdateProductRequest extends ProductRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
            'tags' => 'array|nullable',
        ];
    }
}