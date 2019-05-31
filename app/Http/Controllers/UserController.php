<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function index() {
	return redirect('/');
//	$app = app();
//	$routes = $app->routes->getRoutes();
//	echo "<pre>";
//	var_dump($routes);
	return 'user controller';
    }

    public function download() {
	$pathToFile = storage_path('/app/baidu.png');
	return response()->download($pathToFile, 'google.png');
    }
}
