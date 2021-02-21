@extends('admin.common.main')


@section('content')
    <div class="pd-20">
        <div class="Huiform">

            @include('admin.common.validate')
            <form action="{{url('admin/user/edit',$model)}}" method="post" class="form form-horizontal" id="form-user-add">
{{--                {{method_field('PUT')}}--}}
{{--                让表单模拟put提交--}}
                @method('PUT')
                @csrf
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">实名：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text"id="truename" name="truename" value="{{$model->truename}}">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户名：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" placeholder="" id="username" name="username" value="{{$model->username}}">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>原密码：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="" placeholder="" id="old_password" name="old_password">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="" placeholder="" id="password" name="password">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="" placeholder="" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
                    <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                        <div class="radio-box">
                            <input name="sex" type="radio" id="sex-1" value="1"checked>
                            <label for="sex-1">男</label>
                        </div>
                        <div class="radio-box">
                            <input type="radio" id="sex-2" value="2" name="sex">
                            <label for="sex-2">女</label>
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="{{$model->phone}}" id="phone" name="phone">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" placeholder="@" name="email" id="email" value="{{$model->email}}">
                    </div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
    <script>
        $("#form-user-add").validate({
           //规则
           rules:{
               //-----表单元素名称-----
               username:{
                   //验证规则
                   required:true
               },
               old_password:{
                    required:true
               },
               password:{
                   required:true,
               },
               password_confirmation:{
                   //两次密码一致写法和上面有点不一样 是和谁一致,对方的id名称
                   equalTo:'#password'
               },
               email:{
                   email:true
               },
               phone:{
                   required:true,
                   phone:true
               },
           },
            //消息提示
            messages:{
               username:{
                   required:'用户名称必须要填',
               },
                password:{
                   required:'密码必须写',
                },
            },
            //取消键盘事件
            onkeyup:false,
            //验证成功后的样式
            success:"valid",
            //验证通过之后,处理的方法form dom 对象
            submitHandler:function(form){
               //表单提交
                form.submit();
            }
        });

        //自定义验证规则
        //手机号码验证
        jQuery.validator.addMethod("phone",function(value,element){
            let reg1 = /^\+86-1[3-9]\d{9}$/;
            let reg2 = /^1[3-9]\d{9}$/;
            let ret = reg1.test(value)||reg2.test(value);
            return this.optional(element) || ret;
        },"请输入正确的手机号码");
    </script>
@endsection
