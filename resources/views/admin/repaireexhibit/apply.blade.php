@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.repaireexhibit.apply')}}">修复申请</a></li>
                        <li><a href="javascript:void(0)" onclick="do_submit()">提交申请</a></li>
                        <li><a href="javascript:void(0)" onclick="export_list()">导出</a></li>
                        <li><a href="javascript:void(0)" onclick="do_print()">打印</a></li>
                        <li><a href="{{route('admin.repaireexhibit.apply.add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get">
                            <div class="form-group">
                                <label class="sr-only">修复申请单号</label>
                                <input type="text" name="repair_order_no" placeholder="修复申请单号" class="form-control" value="">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.repaireexhibit.apply')}}'">重置</button>
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
                                <th>修复申请单号</th>
                                <th>修复申请单名称</th>
                                <th>经费预算</th>
                                <th>状态</th>
                                <th>登记人</th>
                                <th>登记日期</th>
                                <th>操作</th>
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    <td>
                                        <input type="checkbox" name="repair_id" value="{{$v['repair_id']}}">
                                    </td>
                                    <td>
                                        {{$v->exhibitName($v['exhibit_sum_register_id'])}}<br/>
                                        {{$v->subsidiaryName($v['subsidiary_id'])}}
                                    </td>
                                    <td>{{$v['repair_order_no']}}</td>
                                    <td>{{$v['repair_order_name']}}</td>
                                    <td>{{$v['plan_expense']}}</td>
                                    <td>{{$v->applyStatus($v['apply_status'])}}</td>
                                    <td>{{$v['register_member']}}</td>
                                    <td>{{$v['register_date']}}</td>
                                    <td>
                                        <a href="{{route('admin.repaireexhibit.apply.delete',['repair_id'=>$v['repair_id']])}}"
                                           onclick="if (confirm('确定要删除此记录吗？')==false) return false">删除</a>
                                        <a href="{{route('admin.repaireexhibit.apply.edit',['repair_id'=>$v['repair_id']])}}">修改</a>
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
        checkd_list = $('input[name="repair_id"]:checked')
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
        $.ajax('{{route("admin.repaireexhibit.apply_submit")}}', {
            method: 'POST',
            data: {'repair_ids':logout_ids},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();",1000)
        });
    }

    /**
     * excel导出
     */
    function export_list() {
        apply_ids = get_logout_ids();
        if(apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        url = '{{route("admin.repaireexhibit.apply.excel")}}' +"?";
        for(i=0;i<apply_ids.length;i++){
            url += "apply_ids["+i.toString()+"]="+apply_ids[i]+"&"
        }
        location.href=url
    }
</script>
