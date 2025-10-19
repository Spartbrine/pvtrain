<?php

namespace App\Services\Category;

use App\Models\Category;

class CategoryStoreService
{
    public function execute($data)
    {
        return Category::create($data);
    }
}
