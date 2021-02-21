<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/admin/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/admin/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/css/pagination.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>用户管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户中心 <span class="c-gray en">&gt;</span> 用户管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="/admin/javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
    <div class="text-c"> 日期范围：
        <input type="text" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}'})" id="datemin" class="input-text Wdate" style="width:120px;">
        -
        <input type="text" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d'})" id="datemax" class="input-text Wdate" style="width:120px;">
        <input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name=""><button type="submit" class="btn btn-success" id="" name=""><i class="icon-search"></i> 搜用户</button>

    </div>
    @include('admin.common.msg')
    <div class="cl pd-5 bg-1 bk-gray mt-20">
    <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="icon-trash"></i> 批量删除</a>
    <a href="{{route('admin.user.create')}}" class="btn btn-primary radius"><i class="icon-plus"></i> 添加用户</a></span>
        <span class="r">共有数据：<strong>88</strong> 条</span>
    </div>
    <table class="table table-border table-bordered table-hover table-bg ">
        <thead>
        <tr class="text-c">
            <th width="25"><input type="checkbox" name="" value=""></th>
            <th width="80">ID</th>
            <th width="100">用户名</th>
            <th width="100">真名</th>
            <th width="40">性别</th>
            <th width="90">手机</th>
            <th width="150">邮箱</th>
            <th width="130">加入时间</th>
            <th width="70">状态</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
        <tr class="text-c">
            <td>
                <input type="checkbox" value="{{$item->id}}" name="id[]">
            </td>
            <td>{{$item->id}}</td>
            <td><u style="cursor:pointer" class="text-primary">{{$item->username}}</u></td>
            <td>{{$item->truename}}</td>
            <td>{{$item->sex}}</td>
            <td>{{$item->phone}}</td>
            <td>{{$item->email}}</td>
            <td>{{$item->created_at}}</td>
            <td class="user-status">
                <span class="label label-success">已启用</span>
            </td>
            <td class="f-14 user-manage">
               <a title="编辑" href="{{route('admin.user.edit',['id'=>$item->id])}}"  class="label label-secondary radius">修改</a>
                @if(auth()->id()!= $item->id)
                    @if($item->deleted_at !=null)
                        <a title="删除" href="{{route('admin.user.restore',['id'=>$item->id])}}" class="label label-primary radius" >还原</a>
                    @else
                        <a title="删除" href="{{route('admin.user.del',['id'=>$item->id])}}" class="label label-danger radius delbtn" >删除</a>
                    @endif
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{$data->links()}}
    <div id="pageNav" class="pageNav"></div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script>
<!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    window.onload = (function(){
        // optional set
        pageNav.pre="&lt;上一页";
        pageNav.next="下一页&gt;";
        // p,当前页码,pn,总页面
        pageNav.fn = function(p,pn){$("#pageinfo").text("当前页:"+p+" 总页: "+pn);};
        //重写分页状态,跳到第三页,总页33页
        pageNav.go(1,13);
    });
    $('.table-sort').dataTable({
        "lengthMenu":false,//显示数量选择
        "bFilter": false,//过滤功能
        "bPaginate": false,//翻页信息
        "bInfo": false,//数量信息
        "aaSorting": [[ 1, "asc" ]],//默认第几个排序  //desc
        "bStateSave": true,//状态保存
        "aoColumnDefs": [
            //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
            {"orderable":false,"aTargets":[0,8,9]}// 制定列不参与排序
        ]
    });
</script>
<script>
    const _token = "{{ csrf_token()}}";

    //给删除按钮绑定事件
    $(".delbtn").click(function (evt) {
        //得到请求的url地址
        let url = $(this).attr("href");
        console.log(url);
        //发起一个delete
        $.ajax({
            url:url,
            data:{_token},
            type:'DELETE',
            dataType:'json',
        }).then(({status,msg})=>{
           if(status == 0){
               //提示插件
               layer.msg(msg,{time:200,icon:1},()=>{
                  //删除当前行
                  $(this).parents('tr').remove();
               });
           }
        });
        //jq取消默认事件
        return false;
    })


    //-----------------批量删除-------------------
    function datadel(){
        //
        layer.confirm('您是真的要删除选中的用户吗?',{
            btn:['确认删除','思考一下']
        },()=>{
           //选中的用户
           let ids = $("input[name='id[]']:checked");
           //删除的ID
            let id = [];
            //循环
            $.each(ids,(key,val)=>{
                //dom对象转为jq对象 $(dom对象)
                //id.push($(val).val())
                id.push(val.value);
            });

            if(id.length >0 ){
                $.ajax({
                    url:"{{route('admin.user.delall')}}",
                    data:{id,_token},
                    type:'DELETE',
                }).then(ret=>{
                   if(ret.status ==0){
                       layer.msg(ret.msg,{time:2000,icon:1},()=>{
                           location.reload();
                       })
                   }
                });
            }
        });

    }
</script>
</body>
</html>
