<?php
namespace App\Listeners;

use App\Events\CacheQueueEvent; //第二种写法

class CacheSubscriber
{
    /**
     * 触发CacheEvent执行这里
     *
     * @param $event
     */
    public function testCache($event)
    {
        //
        info("触发了CacheEvent ； 执行了 testCache 方法");
    }

    /**
     * 触发CacheQueueEvent执行这里
     *
     * @param $event
     */
    public function queueCache($event)
    {
        //
        info("触发了CacheQueueEvent ； 执行了 queueCache 方法");
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
            'App\Events\CacheEvent',
            'App\Listeners\CacheSubscriber@testCache'
        );
        //第二种使用use引入
        $events->listen(
            CacheQueueEvent::class,
            'App\Listeners\CacheSubscriber@queueCache'
        );
    }
}