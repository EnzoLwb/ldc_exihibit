@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.exhibitcollect.apply')}}">查询</a></li>
                        <li><a href="javascript:void(0)" onclick="modify_item()">修改</a></li>
                        <li><a href="javascript:void(0)" onclick="del_item()">删除</a></li>
                        <li><a href="javascript:void(0)" onclick="do_submit()">提交申请</a></li>
                        <li><a href="{{route('admin.exhibitcollect.apply')}}">导出</a></li>
                        <li><a href="javascript:void(0)" onclick="do_print()">打印</a></li>
                        <li class="active"><a href="{{route('admin.exhibitcollect.pic_mode')}}">图文模式</a></li>
                        <li ><a href="{{route('admin.exhibitcollect.add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitcollect.apply')}}">
                            <div class="form-group">
                                <input type="text" name="title" placeholder="申请单号" class="form-control" value="{{request('title')}}">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitcollect.apply')}}'">重置</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
                            <thead>
                            <tr role="row">
                                <th>选择</th>
                                <th>征集申请单号</th>
                                <th>图片展示</th>
                                <th>征集申请单位名称</th>
                                <th>征集采购对象</th>
                                <th>申请征集项目名称</th>
                                <th>申请部门</th>
                                <th>所需征集经费</th>
                                <th>申请征集数量</th>
                                <th>申请人</th>
                                <th>具体征集项目介绍</th>
                                <th>征集原因</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="checkbox" name="collect_apply_id" value="{{$exhibit['collect_apply_id']}}"></td>
                                    <td>{{$exhibit['collect_apply_num']}}</td>
                                    <td><img width="50px" height="50px" src="{{$exhibit['files']}}"></td>
                                    <td>{{$exhibit['collect_apply_depart_name']}}</td>
                                    <td>{{$exhibit['collect_buy_object']}}</td>
                                    <td>{{$exhibit['collect_apply_project_name']}} </td>
                                    <td>{{$exhibit['apply_depart']}} </td>
                                    <td>{{$exhibit['need_fee']}} </td>
                                    <td>{{$exhibit['collect_exhibit_count']}} </td>
                                    <td>{{$exhibit['applyer']}} </td>
                                    <td>{{$exhibit['collect_project_desc']}} </td>
                                    <td>{{$exhibit['collect_reason']}} </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    //修改内容
    function modify_item(){
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0 || collect_apply_ids.length>1){
            layer.alert("请选择并且只选择一项")
            return
        }
        collect_apply_id = $($('input[name="collect_apply_id"]:checked')[0]).val()
        location.href = "{{route('admin.exhibitcollect.add')}}"+"?collect_apply_id="+collect_apply_id
    }
    //删除申请
    function del_item() {
        collect_apply_ids = get_collect_checked_ids();
        if(checkd_list.length==0){
            layer.alert("请至少选择一项")
            return
        }
        $.ajax('{{route("admin.exhibitcollect.apply_del")}}', {
            method: 'POST',
            data: {'collect_apply_ids':collect_apply_ids},
            dataType: 'json'
        }).done(function (response) {
                layer.alert(response.msg)
            setTimeout("location.reload();", 3000)

            });
    }
    function do_print() {
    }

    //功能函数，收集选中的申请项
    function get_collect_checked_ids() {
        checkd_list = $('input[name="collect_apply_id"]:checked')

        collect_apply_ids = []
        for(i = 0; i<checkd_list.length;i++){
            collect_apply_ids.push($(checkd_list[i]).val())
        }
        return collect_apply_ids;
    }
    /**
     * 提交审核
     */
    function do_submit() {
        collect_apply_ids = get_collect_checked_ids();
        if(checkd_list.length==0){
            layer.alert("请至少选择一项")
            return
        }
        $.ajax('{{route("admin.exhibitcollect.apply_submit")}}', {
            method: 'POST',
            data: {'collect_apply_ids':collect_apply_ids},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();", 3000)
        });
    }
</script>

