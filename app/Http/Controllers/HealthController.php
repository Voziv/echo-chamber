<?php

namespace App\Http\Controllers;

use App\Helpers\ConnectionChecker;
use App\Http\Controllers\Controller;

class HealthController extends Controller
{
    public function liveness()
    {
        return 'alive and well';
    }

    public function readiness()
    {
        return 'ready and waiting';
    }

    public function database()
    {
        if (!ConnectionChecker::isDatabaseReady()) {

            abort(500, "Database connection failing");
        }
        return 'Database connection working';
    }

    public function redis()
    {
        if (!ConnectionChecker::isRedisReady()) {
            abort(500, "Redis connection failing");
        }

        return 'Redis connection working';
    }
}
