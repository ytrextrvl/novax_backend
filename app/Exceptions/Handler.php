<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        //
    }

    public function render($request, Throwable $e)
    {
        // Always return JSON for API calls
        if ($request->expectsJson() || $request->is('api/*')) {
            $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
            return response()->json([
                'message' => $e->getMessage() ?: 'Server error',
                'error' => class_basename($e),
            ], $status);
        }

        return parent::render($request, $e);
    }
}
