<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
abstract class Controller
{
    protected function respondSuccess($data = null, string $message = 'success', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    protected function respondFailed($errors = null, string $message = 'Something went wrong', int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'  => $errors,
        ], $status);
    }
}
