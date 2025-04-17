<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

Route::get('/config-clear', function () {
    Artisan::call('config:clear');

    return response()->json([
       'message' => 'Config cleared successfully!',
    ]);
});

Route::get('/cache-clear', function () {
    Artisan::call('cache:clear');

    return response()->json([
        'message'=> 'Cache cleared successfully!',
    ]);
});

Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');

    return response()->json([
        'message'=> 'Optimized cleared successfully!',
    ]);
});

Route::get('/refresh-database', function () {
    Artisan::call('migrate:fresh --seed');

    return response()->json([
        'message' => 'Database refreshed successfully!',
    ]);
});

Route::get('/route-cache', function () {
    Artisan::call('route:cache');

    return response()->json([
        'message' => 'Routes cached successfully!',
    ]);
});

Route::get('/dump-autoload', function () {
    try {
        $output = shell_exec('composer dump-autoload 2>&1');
        return response()->json([
            'message' => 'Composer dump-autoload executed successfully!',
            'output' => $output
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to execute composer dump-autoload!',
            'error' => $e->getMessage()
        ], 500);
    }
});
