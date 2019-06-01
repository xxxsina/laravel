<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;   //门面 facades
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Log;
use App\Users;
//事件
use Event;
use App\Events\CacheEvent;  //一事件
use App\Events\CacheQueueEvent; //二事件
//订阅事件
use App\Events\CommentEvent;
use App\Events\ScoreEvent;


class HomeController extends BaseController
{
    
    public function index(Request $request)
    {
		$input = $request->all();
		var_dump($input);
		echo 1024;	
		$name = $request->name;
		var_dump($name);
		return redirect('hello');
  //     	return view('hello', ['website' => '是是是']);
		// return view('welcome');
    }

    public function mylog() 
    {
    	//测试日志的条用 这里一定要use Log
    	Log::debug('测试', [random_int(1, 1000)]);
    	return 'end';
    }

    public function getCache()
    {
    	echo '<pre>';
    	//设置缓存 还可以 Cache::add(key, value, min) 还有永久 Cache::forever(key, value)
    	// Cache::put('key', 'hello cache 2---2', 10);
    	//获取缓存 & 未获取到可设置默认值
    	$value = Cache::get('key', 'defualt');
    	//获取后删除缓存 还可以移除 Cache::forget(key) 可以清理所有 Cache::flush()
    	// $value = Cache::pull('key');
    	var_dump($value);
    	//给缓存打标签
    	// Cache::tags(['people', 'artists'])->put('John', $john, $minutes);
    	//访问被标签的缓存
    	//$john = Cache::tags(['people', 'artists'])->get('John');
    	//除以标签并清除缓存
    	//Cache::tags(['people', 'authors'])->flush();
    	//Cache::tags('authors')->flush();

    	$users = Cache::remember('users', 10, function(){
    		// return DB::table('users')->get();
    		return null;
    	});
    	// echo $users[0]->name .'<br>';
    	var_dump($users);
    	return 'end';
    }


    public function redis()
    {
    	//设置值	
    	// Redis::set('name', 'Taylor');
    	//获取值
    	// $name = Redis::get('name');

    	//管道命令
    	Redis::pipeline(function ($pipe) {
		    for ($i = 0; $i < 10; $i++) {
		        $pipe->set("key:$i", ++$i);
		    }
		});


    	return ;
    }

    //发布、订阅
    public function mypub()
    {
    	Redis::publish('test-channel', json_encode(['foo' => random_int(1, 10000)]));

    	return '发送完成';
    }

    //cache event 阻塞的写法
    public function cacheEvent()
    {
        $users = Users::find(3);
//        print_r($users->toArray());
        $time = time();
        Event::fire(new CacheEvent($users));
        //或使用函数，event(new CacheEvent($users));

        echo time() - $time;

        return ' <br> end event';
    }

    //cache event 加入队列的写法
    public function cacheQueueEvent()
    {
        $users = Users::find(4);
//        print_r($users->toArray());
        $time = time();
        Event::fire(new CacheQueueEvent($users));
        //或使用函数，event(new CacheQueueEvent($users));

        echo time() - $time;

        return ' <br> end event';
    }

    /**
     * 事件订阅
     * 这里举一个评论/积分兑换的例子
     * 1.评论是一个事件、积分兑换是一个事件
     *      所以增加
     *      App\Events\CommentEvent;
     *      App\Events\ScoreEvent;
     * 2.这2个事件都需要操作消费记录，这里需要一个listener
     *      所以增加 (里面就包含了得和扣积分的操作)
     *      App\Listeners\TreasureLogsListener
     *
     * @return string
     */
    public function eventSub()
    {
        $time = time();

        event(new CommentEvent(3));

        $users = Users::find(4);
        event(new ScoreEvent($users));

        echo time() - $time;

        return ' end';
    }
}


