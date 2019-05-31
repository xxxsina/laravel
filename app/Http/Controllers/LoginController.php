<?php
//自定义登录
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * 处理登录认证
     *
     * @return Response
     * @translator laravelacademy.org
     */
    public function authenticate(Request $request)
    {
        // echo bcrypt($request->password);exit;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // 认证通过...
            // return '登录成功';
            return redirect()->intended('dashboard');
        }

        return '成功失败';
    }

    //退出登录
    public function logout()
    {
        Auth::logout();
        return redirect('hello');
    }
}