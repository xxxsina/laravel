<?php
//这里自定义个命令监控 发布/订阅 长住内存；但是必须在配置redis过期时间的时候设置config/database.php redis read_write_timeout=0
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Log;

class RedisSubscribe extends Command
{
    /**
     * 控制台命令名称 #php artisan redis:subscribe
     * 一定要这样启动才不报错 如下（相应文件夹必须有相关权限）：
     * nohup php artisan redis:subscribe > /var/log/laravel_cli/redis.subscribe.log 2>&1 &
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:subscribe';

    /**
     * 控制台命令描述
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to a Redis channel';

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
     * 执行控制台命令
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Redis::subscribe(['test-channel'], function($message) {
            //这里就不用log记录了，直接在/var/log/laravel_cli/redis.subscribe.log
//            Log::info($message);//这里还有个坑，在做了ab测试后，居然不写日志了，只有重启才行.
            echo $message;
        });
    }
}
