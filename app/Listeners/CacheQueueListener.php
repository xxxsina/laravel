<?php
/**
 * 启动的方式
 * 一：
 * nohup php artisan queue:work redis --daemon --quiet --queue=custom_queue --delay=3 --sleep=3 --tries=3 > /var/log/laravel_cli/queue.event.log 2>&1 &
 * 二：
 * php artisan queue:work redis --daemon --quiet --queue=default --delay=3 --sleep=3 --tries=3
 */
namespace App\Listeners;

use Log;
use Cache;
use App\Events\CacheQueueEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

//这里生成了类名 需要手动增加 implements ShouldQueue ； 这个时候就可以按照一般的事件写了，还可以延时执行，异步
class CacheQueueListener implements ShouldQueue
{
    //尼玛必须加这个才不报错
    use InteractsWithQueue;

    /**
     * 任务应该发送到的队列的连接的名称
     * 目前这里可以加入redis队列了，也可以使用zrange +name 0 -1 查看，
     * 但是就是不出列处理
     *      说的是要运行php artisan queue:work  或者 php artisan queue:listen 但是也没得用的哇
     *      现在怀疑是名称不对 ，但是defualt了也不对
     *
     *   成功了！！！ 这里有个坑 就是启动队列的时候 ； 慢慢讲一下流程
     *   事件加入队列后需要出列执行，这个是时候需要有队列任务跑起的，所以执行下列命令
     *   php artisan queue:work redis --daemon --quiet --queue=default --delay=3 --sleep=3 --tries=3
     *   参数说明：
     *   --daemon   #据说可以节省 CPU 使用
     *   --quiet    #不输出任何内容
     *   --queue    #默认监听那个队列  名字
     *   --delay    #一个任务失败后，延迟多长时间后再重试，单位是秒
     *   --sleep    #去 Redis 中拿任务的时候，发现没有任务，休息多长时间，单位是秒
     *   --tries    #定义失败任务最多重试次数
     *   特别注意：里面有redis 这个必须要写了，才会去redis里面去拿任务(这里应该是和下面设置的connection对应的)；
     *   尼玛搞了老半天，才搞懂这个坑
     *   所以还是要看文档啊 https://learnku.com/docs/laravel/5.5/queues/1324
     *
     * @var string|null
     */
    public $connection = 'redis';


    /**
     * 可以将事件放入指定名称的队列中
     * php artisan queue:work redis --daemon --quiet --queue=custom_queue --delay=3 --sleep=3 --tries=3
     *
     * @var string
     */
    public $queue = 'custom_queue';
    //还可以设置延时时间 秒
    public $delay = 2;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CacheQueueEvent  $event
     * @return void
     */
    public function handle(CacheQueueEvent $event)
    {
        //这里已经把事件的依赖取得。这里是非阻塞的
        $users = $event->users;
        $key = 'user_queue_' . $users->id;
//        sleep(10);
//        $this->release(10); //这个可以延时执行 10秒
        Cache::put($key, $users, 10);
        /**
         * 这里日志也有坑啊  就是权限问题
         * 如果.env文件中配置的是Daily 那么就要到 Illuminate\Log\Writer.php中去修改RotatingFileHandler 里面的参数 改成0666
         */
        Log::info('延时、自定义队列、事件监听' . random_int(1, 100000));
    }

    /**
     * 这里处理的是任务失败的函数
     */
    public function failed(CacheQueueEvent $event, $exception)
    {
        //to do
        info('失败走这里' . $exception);
    }
}
