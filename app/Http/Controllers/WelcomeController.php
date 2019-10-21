<?php

namespace App\Http\Controllers;

use App\Helpers\ConnectionChecker;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class WelcomeController extends Controller
{
    public function welcome()
    {
        return view('welcome', [
            'echos' => $this->getEchos(),
            'echo_jobs' => $this->getEchoJobs(),
            'last_job' => Redis::get('last_job') ?? 'Never',
            'last_command' => Redis::get('last_command') ?? 'Never',
            'database_is_healthy' => ConnectionChecker::isDatabaseReady(),
            'redis_is_healthy' => ConnectionChecker::isRedisReady()
        ]);
    }

    private function getEchos(): array {
        $echos = [];
        $llen = Redis::llen('echos');
        if ($llen > 0) {
            $echos = collect(Redis::lrange('echos', 0, $llen))
            ->map(function($echo) {
                return json_decode($echo, true);
            })->toArray();
        }

        return $echos;
    }

    private function getEchoJobs(): array {
        $echos = [];
        $llen = Redis::llen('echo_jobs');
        if ($llen > 0) {
            $echos = collect(Redis::lrange('echo_jobs', 0, $llen))
            ->map(function($echo) {
                return json_decode($echo, true);
            })->toArray();
        }

        return $echos;
    }
}
