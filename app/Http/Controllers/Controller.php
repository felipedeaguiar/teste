<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

/**
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    /**
     * @param $data
     * @param $status
     * @return array
     */
    public function toSuccess($data = [], $status = 200, $pagination = false): JsonResponse
    {
        $return =[
            'success' => true,
            'data'    => $data
        ];

        if ($pagination) {
            $return['pagination'] = [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
            ];
        }

        return response()->json($return, $status
        );
    }

    /**
     * @param $message
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function toError($message = null, $status = 400): JsonResponse
    {
        return response()->json(
            [
                'success' => false,
                'message' => $message
            ], $status
        );
    }
}
