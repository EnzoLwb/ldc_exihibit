@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitidentify.expert')}}">查询</a></li>
                        <li><a href="javascript:void(0)" onclick="start_experts(1)">启用</a></li>
                        <li><a href="javascript:void(0)" onclick="start_experts(0)">禁用</a></li>
                        <li><a href="{{route('admin.exhibitidentify.expert_add')}}">新增</a></li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitidentify.expert')}}">
                            <div class="form-group">
                                <input type="text" name="title" placeholder="姓名" class="form-control" value="{{request('title')}}">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitidentify.expert')}}'">重置</button>
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
                                <th>姓名</th>
                                <th>性别</th>
                                <th>状态</th>
                                <th>职务</th>
                                <th>职称</th>
                                <th>所属部门</th>
                                <th>鉴定成果</th>
                                <th>业务专长</th>
                                <th>联系方式</th>
                                <th>操作</th>

                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                  <td><input type="checkbox" name="expert_id" value="{{$exhibit['expert_id']}}"></td>
                                    <td>{{$exhibit['username']}}</td>
                                    <td>{{\App\Dao\ConstDao::$expert_sex_desc[$exhibit['sex']]}}</td>
                                    <td>{{\App\Dao\ConstDao::$expert_status_desc[$exhibit['status']]}}</td>
                                    <td>{{$exhibit['duties']}}</td>
                                    <td>{{$exhibit['job_title']}}</td>
                                    <td>{{$exhibit['depart']}}</td>
                                    <td>{{$exhibit['identify_result']}}</td>
                                    <td>{{$exhibit['profession_skills']}}</td>
                                    <td>{{$exhibit['phone']}}</td>
                                    <td>
                                        <a href="{{route('admin.exhibitidentify.expert_add')."?expert_id=".$exhibit['expert_id']}}">修改</a>
                                        <a href="{{route('admin.exhibitidentify.expert_del')."?expert_id=".$exhibit['expert_id']}}">删除</a>
                                    </td>
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
    //功能函数，收集选中的申请项
    function get_collect_checked_ids() {
        checkd_list = $('input[name="expert_id"]:checked')
        collect_apply_ids = []
        for(i = 0; i<checkd_list.length;i++){
            collect_apply_ids.push($(checkd_list[i]).val())
        }
        return collect_apply_ids;
    }

    function start_experts(is_start) {
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        $.ajax('{{route("admin.exhibitidentify.change_expert_status")}}', {
            method: 'POST',
            data: {'expert_id':collect_apply_ids,"_token":"{{csrf_token()}}",'status':is_start},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();", 3000)
        });
    }

</script>