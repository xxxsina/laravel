<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
//    return view('welcome');
	return view('home', ['website' => '哈哈哈']);
});
*/
//修改为控制器路由
Route::get('index', 'HomeController@index');
Route::get('cache', 'HomeController@getCache');
Route::get('redis', 'HomeController@redis');
Route::get('log', 'HomeController@mylog');
Route::get('pub', 'HomeController@mypub');
Route::get('cevent', 'HomeController@cacheEvent');
Route::get('cqevent', 'HomeController@cacheQueueEvent');
Route::get('esub', 'HomeController@eventSub');
//发布、订阅
Route::get('publish', function () {
    // 路由逻辑...
    Redis::publish('test-channel', json_encode(['foo' => 'bar']));
});

Route::get('/', function(){
	echo url('/xxxooo');
	echo "<br>";
	// $a = $this->routes->getRoutes();
	// var_dump($a);
	
	echo $url = action('HomeController@index');
	return redirect($url);
	return view('greeting', ['name'=>'James']);
});

//Route::view('view', 'home', ['website' => '嘻嘻嘻']);

Route::get('hello', function(){
	return view('hello', ['name'=>'lee']);
});

//Route::get('/user', 'UserController@index');
Route::get('/user/download', 'UserController@download');

Route::get('con', function(){
	return redirect('user');
});

//////////////post controller start//////////////////////
Route::get('post', 'PostController@index');
Route::get('post/show/{id}', 'PostController@show');
Route::get('post/update/{id}', 'PostController@update');
Route::get('post/detail/{id}', 'PostController@detail');
//////////////post controller end//////////////////////

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('login', 'LoginController@authenticate')->name('login');
// Route::get('logout', 'LoginController@logout');

// Route::get('center', 'CenterController@index')->middleware('auth');
Route::get('center', 'CenterController@index')->middleware('auth.basic');