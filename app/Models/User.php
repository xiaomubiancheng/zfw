<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthUser;

//软删除类
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends AuthUser
{
    //调用定义的trait类和继承效果一样
    use SoftDeletes;
    //软删除标识字段
    protected $dates = ['deleted_at'];

    //设置不添加的字段
    //拒绝不添加的字段
    protected $guarded = [];
}
