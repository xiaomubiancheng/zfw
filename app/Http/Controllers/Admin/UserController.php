<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends BaseController
{
    //用户列表
    public function index(){
        //分页 withTrashed 显示所有的,包括已经进行了软删除的
        $data = User::orderBy('id','asc')->withTrashed()->paginate($this->pagesize);
        return view('admin.user.index',compact('data'));
    }

    //用户添加页面
    public function create()
    {
        return view('admin.user.create');
    }

    //用户添加处理
    public function store(Request $request){
        #1.验证
        $this->validate($request,[
           //用户名唯一性验证
            'username' => 'required|unique:users,username',
            'truename' => 'required',
            //两次密码是否一致的验证
            'password' => 'required|confirmed',
            //自定义验证规则
            'phone' => 'nullable|phone'
        ]);

        #2.获取表单数据
        $post = $request->except(['_token','password_confirmation']);
        //数据入库
        $userModel = User::create($post);
        //密码
        $pwd = $post['password'];
        //发送邮件给用户
        Mail::send('mail.useradd',compact('userModel','pwd'),function(Message $message) use($userModel){
           //发给谁
            $message->to($userModel->email);
            //主题
            $message->subject('开通账号邮件通知');
        });
        //跳转到列表页
        return redirect(route('admin.user.index'))->with('success','添加用户成功');
    }

    //删除
    public function del(int $id){


        User::find($id)->delete();
        //强制删除 在配置了软删除的时候,真实的删除操作
//        User::find($id)->forceDelete();

        return ['status'=>0,'msg'=>'删除成功'];
    }

    //还原
    public function restore(int $id){
        //onlyTrashed 还原
        User::onlyTrashed()->where('id',$id)->restore();
        return redirect(route('admin.user.index'))->with('success','还原成功');
    }

    //全选删除
    public function delall(Request $request){
        $ids = $request->get('id');
        User::destory($ids);
        return ['status'=>0,'msg'=>'全选删除成功'];
    }

    //修改页显示
    public function edit(int $id){
        $model = User::find($id);
        return view('admin.user.edit',compact('model'));
    }

    //修改处理
    public function update(Request $request,int $id){
        $model = User::find($id);
        //原密码 明文
        $old_password = $request->get('old_password');
        //原密码 密文
        $old_password_secret = $model->password;
        //检查明文和密码是否一致
        $bool = Hash::check($old_password,$old_password_secret);
        if($bool){
            $data = $request->only([
               'truename',
               'password',
               'phone',
               'sex',
               'email'
            ]);
            if(!empty($dta['password'])){
                $data['password'] = bcrypt($data['password']);
            }else{
                unset($data['password']);
            }
            $model->update($data);
            return redirect(route('admin.user.index'))->with('success','修改用户成功');
        }
        return redirect(route('admin.user.edit',$model))->withErrors(['error'=>'原密码不正确']);
    }
}
