<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $data
     * @param string|null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function responseSuccess($data, string $message = null, int $statusCode = 200): JsonResponse
    {
        if (!$message) {
            $message = __('message.success');
        }
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * @param string|null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function responseError(string $message = null, int $statusCode = 404): JsonResponse
    {
        if (!$message) {
            $message = __('message.not_found');
        }
        return response()->json([
            'message' => $message,
        ], $statusCode);
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    protected function responseSuccessWithPaginate($data): JsonResponse
    {
        $responseData = [
            'current_page' => $data->currentPage(),
            'data' => $data,
            'last_page' => $data->lastPage(),
            'total' => $data->total()
        ];

        return $this->responseSuccess($responseData);

    }
}
