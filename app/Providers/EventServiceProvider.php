<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        //一事件 阻塞
        'App\Events\CacheEvent' => [
            'App\Listeners\CacheListener',
        ],
        //二事件 队列
        'App\Events\CacheQueueEvent' => [
            'App\Listeners\CacheQueueListener',
        ],
    ];

    /**
     * 事件订阅
     * 见home Controller 说明
     *
     * @var array
     */
    protected $subscribe = [
        'App\Listeners\TreasureLogsListener',
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
