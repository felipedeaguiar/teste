<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaleResource;
use App\Models\Sale;
use App\Services\SaleService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 *
 */
class SaleController extends Controller
{
    /**
     * @var SaleService
     */
    protected $saleService;

    /**
     * @param SaleService $saleService
     */
    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $products = $request->input('products', []);

            $sale = $this->saleService->create($products);

            return $this->toSuccess(new SaleResource($sale->load('products')));

        } catch (\Exception $e) {

            return $this->toError($e->getMessage());
        }
    }

    /**
     * @param string $uuid
     * @return array|JsonResponse
     */
    public function show(string $uuid): JsonResponse
    {
        try {
            $sale = Sale::where('uuid', $uuid)->firstOrFail();
            return $this->toSuccess(new SaleResource($sale->load('products')));
        } catch (ModelNotFoundException $e) {
            return $this->toError('Unknow sale', 404);
        }
    }

    public function getAll(Request $request)
    {

    }
}
