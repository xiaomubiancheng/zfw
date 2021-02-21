<?php

//后台路由

//路由分组
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    //登录显示  name给路由起一个别名
    Route::get('login','LoginController@index')->name('admin.login');
    //登录处理
    Route::post('login','LoginController@login')->name('admin.login');

    Route::group(['middleware'=>['checkadmin']],function(){
        //后台首页显示
        Route::get('index','IndexController@index')->name('admin.index');
        //欢迎页面显示
        Route::get('welcome','IndexController@welcome')->name('admin.welcome');
        //退出
        Route::get('logout','IndexController@logout')->name('admin.logout');

        //---------------------------用户管理------------------
        //用户列表
        Route::get('user/index','UserController@index')->name('admin.user.index');
        //添加用户
        Route::get('/user/add','UserController@create')->name('admin.user.create');
        //添加用户处理
        Route::post('/user/add','UserController@store')->name('admin.user.store');
        //删除用户
        Route::delete('/user/del/{id}', 'UserController@del')->name('admin.user.del');
        //还原
        Route::get('user/restore/{id}','UserController@restore')->name('admin.user.restore');
        //全选删除
        Route::delete('user/delall','UserController@delall')->name('admin.user.delall');

        //修改用户
        Route::get('user/edit/{id}','UserController@edit')->name('admin.user.edit');
        //修改用户处理
        Route::put('user/edit/{id}','UserController@update')->name('admin.user.edit');

        //发送邮件
        Route::get('user/email',function(){
           \Mail::raw('测试',function(\Illuminate\Mail\Message $message){
               //获取回调方法中的形参数
               //dump(func_get_args());
               //发送给谁
               $message->to('1462906364@qq.com');
               //主题
               $message->subject('测试邮件');
           });
        });

        //发送富文本
        Route::get('user/email1',function(){
           \Mail::send('mail.adduser',['user'=>'张三'],function(\Illuminate\Mail\Message $message){
                //发给谁
               $message->to('1462906364@qq.com');
               //主题
               $message->subject('测试邮件');
           });
        });
    });


});
