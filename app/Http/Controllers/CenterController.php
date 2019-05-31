<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CenterController extends Controller
{
    //
    public function index(Request $request)
    {
    	return 'user center index ; data: ' . $request->user()->email;
    }
}
