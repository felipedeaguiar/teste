<?php

namespace App\Services;


use App\Models\Product;

/**
 *
 */
class ProductService
{
    public function getAll($filters = [])
    {
        $pageSize = 10;

        if (array_key_exists('pageSize', $filters)) {
            $pageSize = $filters['pageSize'];
        }

        $products = Product::paginate($pageSize);

        return $products;
    }
}
