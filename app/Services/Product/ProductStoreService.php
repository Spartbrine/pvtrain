<?php

namespace App\Services\Product;

use App\Models\Category;
use App\Models\Product;
use Log;

class ProductStoreService
{
    public function execute(array $data)
    {
        $category = '';

        if (!isset($data['category_id']) && !isset($data['category_name']) && isset($data['category_name']) === '')
            return false;

        if (isset($data['category_name']) && $data['category_name'] !== '') {
            $category = $data["category_name"] ?? null;
            unset($data["category_name"]);

            $categoryModel = Category::create(
                [
                    'name' => $category,
                    'description' => 'Descripción por defecto.'
                ]
            );

            $data['category_id'] = $categoryModel->id;

            return Product::create($data);
        }

        if (isset($data['category_id']) && $data['category_id'] !== '')
            return false;

        if (isset($data['category_id']))
            return Product::create($data);

    }
}
