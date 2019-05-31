<?php

namespace App\Http\Controllers;

use Validator;
use App\Users;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;

use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('detail');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        var_dump($user->name);
        var_dump($user->email);

        var_dump($request->user());
        // var_dump($request->name);
        //get users table
    	// $users = DB::table('users')->get();
    	echo "<pre>";
    	// var_dump($users);

    	// foreach($users as $user){
    	// 	var_dump($user);
    	// }
    	// echo "<hr>";
    	// $names = DB::table('users')->pluck('name');
    	// var_dump($names);
        // echo "</pre>";
     //    $data = DB::table('users')->paginate(2);
     //    $data2 = DB::table('users')->simplePaginate(1);
        // echo "<hr>";
        $fuser = new Users;
        // $result = $fuser::all();
        // var_dump($result);
        $second = $fuser::find(3);
        var_dump($second->name);
        // $test = Test::find(1);
        // var_dump($test->migration);
        // $xx = Users::find(1)->migration;
        // var_dump($xx->id);
        // $second->name= $request->name;
        // $second->save();
    	// return view('post', ['data' => $data, 'data2' => $data2]);
        return ;
    }

    public function detail(Request $request)
    {
        $result = new UserResource(Users::find(4));
        // var_dump($result);

        $result2 = new UserCollection(users::all());
        // var_dump($result2);
        return [$result2, $result];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get users id info
    	$user = DB::table('users')->where('id', $id)->first();
    	// echo '<pre>';
    	// var_dump($user);
    	// echo $user->name;

        $result = Users::all();
        // var_dump($result->toArray());
    	return $result->append('data')->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users|max:8',
            // 'body' => 'required',
        ], [
            'max' => ':attribute 最多不能超过8个字符'
        ], [
            'name' => '联系人名称',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            echo $errors->first('name');
            return '  / NO';
        }

        // echo "<pre>";
        // var_dump($id);
        // var_dump($request->name);
        //save for update
        $fuser = new Users;
        $rs = $fuser::find($id);
        $this->authorize('update', $rs);    //验证是否授权
        // var_dump($rs);
        $rs->name= $request->name;
        $a = $rs->save();
        var_dump($a);
        return 'ok';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
