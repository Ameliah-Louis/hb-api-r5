<?php

namespace App\Config;

use Throwable;

class ExceptionHandler
{
  public static function registerHandler(): void
  {
    set_exception_handler(function (Throwable $ex): void {
      http_response_code(500);
      echo json_encode([
        'error' => [
          'code' => $ex->getCode(),
          'message' => "Une erreur est survenue"
        ]
      ]);
    });
  }
}
