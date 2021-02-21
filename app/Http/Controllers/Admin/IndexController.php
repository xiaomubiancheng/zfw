<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index()
    {
        return view('admin.index.index');
    }

    public function welcome(){
        return view('admin.index.welcome');
    }

    //退出
    public function logout(){
        //用户退出 清空session
        auth()->logout();
        //跳转 带提示 闪存 session
        return redirect(route('admin.login'))->with('success','请重新登录');
    }

}
