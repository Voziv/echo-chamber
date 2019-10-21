<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'echo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = [
            'node' => env('MY_NODE_NAME'),
            'pod' => env('MY_POD_NAME'),
            'run_at' => Carbon::now()->toDateTimeString(),
        ];

        $length = Redis::llen('echos');
        while ($length >= 20) {
            Redis::rpop('echos');
            $length = Redis::llen('echos');
        };

        Redis::lpush('echos', json_encode($data));


        Redis::set('last_command', $data['run_at']);
    }
}
