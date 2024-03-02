<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Sale;

/**
 *
 */
class SaleService
{

    /**
     * @param array $products
     * @return Sale
     * @throws \Exception
     */
    public function create(array $products): Sale
    {
        $validator = \Validator::make(['products' => $products], [
            'products' => 'required|array|min:1', // Verifica se é um array e tem pelo menos 1 elemento
            'products.*.id' => 'required|exists:products,id',
            'products.*.amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        // Inicia a transação
        \DB::beginTransaction();

        try {

            $sale = new Sale();
            $sale->save();

            foreach ($products as $productData) {
                $product = Product::findOrFail($productData['id']);
                $amount = $productData['amount'];

                $sale->products()->attach($product, ['amount' => $amount]);

                // Atualiza o valor total da venda
                $sale->amount += $product->price * $amount;
            }

            // Finaliza a transação
            \DB::commit();

        } catch (\Exception $e) {
            // Em caso de erro, reverte a transação
            \DB::rollBack();

            throw $e;
        }

        return $sale;
    }

    /**
     * @param $filters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($filters = [])
    {
        $pageSize = 10;
        $query = Sale::query();

        if (array_key_exists('pageSize', $filters)) {
            $pageSize = $filters['pageSize'];
        }

        if (array_key_exists('withProducts', $filters)) {
            $query->with('products');
        }

        $sales = $query->paginate($pageSize);

        return $sales;
    }
}
