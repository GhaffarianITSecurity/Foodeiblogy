<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HealthCheckController extends Controller
{
    public function check()
    {
        try {
            // Basic system check
            $status = [
                'status' => 'healthy',
                'timestamp' => now()->toIso8601String(),
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'environment' => app()->environment(),
                'app_debug' => config('app.debug'),
                'app_env' => config('app.env')
            ];

            // Try database connection if configured
            if (config('database.default')) {
                try {
                    DB::connection()->getPdo();
                    $status['database'] = 'connected';
                    $status['database_name'] = config('database.connections.' . config('database.default') . '.database');
                } catch (\Exception $e) {
                    Log::error('Database connection error: ' . $e->getMessage());
                    $status['database'] = 'disconnected';
                    $status['database_error'] = $e->getMessage();
                }
            }

            return response()->json($status);
        } catch (\Exception $e) {
            Log::error('Health check error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'status' => 'unhealthy',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
} 