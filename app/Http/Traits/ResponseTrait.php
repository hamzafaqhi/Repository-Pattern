<?php

namespace App\Http\Traits;

trait ResponseTrait
{
   /**
     * handel response json
     * @param bool $status
     * @param string $msg
     * @param array $data
     * @param null $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($status = true, $data = [], $message = null, $statusCode = null) {
        
        $statusCode = $statusCode ?? ($status ? 200 : 400);
        return response()->json([
            'success' => $status,
            'code' => $statusCode,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

}