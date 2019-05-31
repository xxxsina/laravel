<?php

namespace App\Listeners;

use App\Events\CommentEvent;
//这里还可以加入队列
use Illuminate\Contracts\Queue\ShouldQueue;

class TreasureLogsListener implements ShouldQueue
{
    //添加这几行就可以成功加入队列咯 但是不要忘了 这个需要开启任务先 并且名字要对
//    public $connection = 'redis';
//    public $queue = 'custom_queue';
//    public $delay = 2;

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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }

    /**
     * 触发 CommentEvent 执行这里
     *
     * @param $event
     */
    public function inScore($event)
    {
        //
        info("触发了 CommentEvent ； 执行了 inScore 方法" . $event->uid);
    }

    /**
     * 触发 ScoreEvent 执行这里
     *
     * @param $event
     */
    public function outScore($event)
    {
        //
        sleep(3);
        info("触发了 ScoreEvent ； 执行了 outScore 方法" . var_export($event->objUser->toArray(), true));
    }

    /**
     * 为订阅者注册监听器.
     * 这里2中写法
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        //第一种写法直接地址引入
        $events->listen(
            'App\Events\ScoreEvent',
            'App\Listeners\TreasureLogsListener@outScore'
        );
        //第二种使用use引入
        $events->listen(
            CommentEvent::class,
            'App\Listeners\TreasureLogsListener@inScore'
        );
    }
}
