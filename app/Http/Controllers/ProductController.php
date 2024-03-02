<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

/**
 *
 */
class ProductController extends Controller
{
    /**
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $result = $this->productService->getAll($request->query());

        if (!empty($result)) {
            return $this->toSuccess(ProductResource::collection($result), 200, true);
        }

        return $this->toSuccess([],201);
    }
}
