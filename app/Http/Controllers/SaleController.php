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
     * @return array|JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $result = $this->saleService->getAll($request->query());

        if (!empty($result)) {
            return $this->toSuccess(SaleResource::collection($result), 200, true);
        }

        return $this->toSuccess([],201);
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
            $sale = $this->saleService->getByUuid($uuid);
            return $this->toSuccess(new SaleResource($sale->load('products')));
        } catch (ModelNotFoundException $e) {
            return $this->toError('Unknow sale', 404);
        }
    }


    /**
     * @param string $uuid
     * @return array|JsonResponse
     */
    public function cancel(string $uuid): JsonResponse
    {
        try {
            $this->saleService->cancel($uuid);
            return $this->toSuccess();

        } catch (ModelNotFoundException $e) {
            return $this->toError('Unknow sale', 404);
        }
    }

    public function addProduct(string $uuid, Request $request)
    {
        $this->saleService->getByUuid($uuid);
        $this->saleService->addProduct();
    }
}
