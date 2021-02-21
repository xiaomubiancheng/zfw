<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        //判断用户是否已经登录过
        if(auth()->check()){  //默认
            //跳转到后页
            return redirect(route('admin.index'));
        }
        return view('admin.login.login');
    }

    //
    public function login(Request $request)
    {

        //表单验证
        $post = $request->validate([
           'username'=>'required',
           'password'=>'required',
        ]);

        //登录
        $bool = auth()->attempt($post);
        if($bool){ //登录成功!
           return redirect(route('admin.index'));
        }

        return redirect(route('admin.login'))->withErrors(['error'=>'登录失败']);

    }

}
