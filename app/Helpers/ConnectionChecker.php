<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ConnectionChecker
{
    public static function isDatabaseReady($connection = null)
    {
        $isReady = true;
        try {
            DB::connection($connection)->getPdo();
        } catch (\Exception $e) {
            Log::error($e);
            $isReady = false;
        }

        return $isReady;
    }

    public static function isRedisReady($connection = null)
    {
        $isReady = true;
        try {
            $redis = Redis::connection($connection);
        } catch (\Exception $e) {
            Log::error($e);
            $isReady = false;
        }

        return $isReady;
    }
}
