<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            'node' => env('MY_NODE_NAME'),
            'pod' => env('MY_POD_NAME'),
            'run_at' => Carbon::now()->toDateTimeString(),
        ];

        $length = Redis::llen('echo_jobs');
        while ($length >= 20) {
            Redis::rpop('echo_jobs');
            $length = Redis::llen('echo_jobs');
        };

        Redis::lpush('echo_jobs', json_encode($data));

        Redis::set('last_job', $data['run_at']);
    }
}
