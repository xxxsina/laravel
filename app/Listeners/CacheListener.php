<?php

namespace App\Listeners;

use Cache;
use Log;
use App\Events\CacheEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CacheListener
{
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
     * @param  CacheEvent  $event
     * @return void
     */
    public function handle(CacheEvent $event)
    {
        //这里已经把事件的依赖取得。这里是阻塞的
        $users = $event->users;
        $key = 'user_' . $users->id;
        sleep(2);
        Cache::put($key, $users, 10);
        Log::info('保存文章到缓存成功！',['id'=>$users->id,'name'=>$users->name]);
    }
}
