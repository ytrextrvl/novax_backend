<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    /**
     * Health check - returns OK if service is running
     */
    public function health(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    /**
     * Readiness check - checks database connectivity
     */
    public function ready(): JsonResponse
    {
        try {
            DB::connection()->getPdo();
            $dbStatus = 'connected';
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'not_ready',
                'database' => 'disconnected',
                'error' => 'Database connection failed',
            ], 503);
        }

        return response()->json([
            'status' => 'ready',
            'database' => $dbStatus,
        ]);
    }

    /**
     * Version info - returns build version and git info
     */
    public function version(): JsonResponse
    {
        return response()->json([
            'version' => env('APP_VERSION', '1.0.0'),
            'git_sha' => env('GIT_SHA', 'unknown'),
            'build_time' => env('BUILD_TIME', now()->toIso8601String()),
        ]);
    }
}
