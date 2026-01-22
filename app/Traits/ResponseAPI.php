<?php

namespace App\Traits;

trait ResponseAPI {
  protected function success($message, $data = [], $statusCode = 200, $error = false) {
    return response()->json([
      "message" => $message,
      "data" => $data,
      'error' => $error
    ], $statusCode);
  }

  protected function error($message, $data = [], $statusCode = 500, $error = true) {
    return response()->json([
      "message" => $message,
      "data" => $data,
      'error' => $error
    ], $statusCode);
  }
}