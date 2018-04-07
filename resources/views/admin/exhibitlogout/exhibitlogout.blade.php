@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitlogout')}}">藏品注销</a></li>
                        <li><a href="javascript:void(0)" onclick="do_submit()">提交申请</a></li>
                        <li><a href="javascript:void(0)" onclick="export_list()">导出</a></li>
                        <li><a href="javascript:void(0)" onclick="do_print()">打印</a></li>
                        <li><a href="{{route('admin.exhibitlogout.add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitlogout')}}">
                            <div class="form-group">
                                <label class="sr-only">藏品名称</label>
                                <input type="text" name="logout_num" placeholder="藏品名称" class="form-control" value="">
                            </div>
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitlogout')}}'">重置</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover">
                            <tr class="gradeA">
                                <th>选择</th>
                                <th>藏品名称</th>
                                <th>注销凭证号</th>
                                <th>注销凭证名称</th>
                                <th>注销日期</th>
                                <th>注销批准文号</th>
                                <th>注销原因</th>
                                <th>详情描述</th>
                                <th>申请状态</th>
                                <th>登记人</th>
                                <th>登记日期</th>
                                <th>操作</th>
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    <td>
                                        <input type="checkbox" name="logout_id" value="{{$v['logout_id']}}">
                                    </td>
                                    <td>{{$v['name']}}</td>
                                    <td>{{$v['logout_num']}}</td>
                                    <td>{{$v['logout_name']}}</td>
                                    <td>{{$v['logout_date']}}</td>
                                    <td>{{$v['logout_pizhun_num']}}</td>
                                    <td>{{$v['logout_reason']}}</td>
                                    <td>{{$v['logout_desc']}}</td>
                                    <td>{{$v->applyStatus($v['status'])}}</td>
                                    <td>{{$v['register']}}</td>
                                    <td>{{$v['register_date']}}</td>
                                    <td>
                                        <a href="{{route('admin.exhibitlogout.delete',['logout_id'=>$v['logout_id']])}}"
                                           onclick="if (confirm('确定要删除此记录吗？')==false) return false">删除</a>
                                        <a href="{{route('admin.exhibitlogout.edit',['logout_id'=>$v['logout_id']])}}">修改</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <div>共 {{ $data->total() }} 条记录</div>
                               <div>{!! $data->links() !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    //打印功能
    function do_print() {
        window.document.body.innerHTML==window.document.body.innerHTML; //把需要打印的指定内容赋给body.innerHTML
        window.print(); //调用浏览器的打印功能打印指定区域
    }

    //功能函数，收集选中的申请项
    function get_logout_ids() {
        checkd_list = $('input[name="logout_id"]:checked')
        logout_ids = []
        for(i = 0; i<checkd_list.length;i++){
            logout_ids.push($(checkd_list[i]).val())
        }
        return logout_ids;
    }

    /**
     * 提交审核
     */
    function do_submit() {
        //选中的id
        logout_ids = get_logout_ids();
        if(logout_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        $.ajax('{{route("admin.exhibitlogout.apply_submit")}}', {
            method: 'POST',
            data: {'logout_ids':logout_ids},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();",1000)
        });
    }

    /**
     * 导出申请列表
     */
    function export_list() {
        apply_ids = get_logout_ids();
        if(apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        url = '{{route("admin.exhibitlogout.excel")}}' +"?";
        for(i=0;i<apply_ids.length;i++){
            url += "apply_ids["+i.toString()+"]="+apply_ids[i]+"&"
        }
        location.href=url
    }
</script>
