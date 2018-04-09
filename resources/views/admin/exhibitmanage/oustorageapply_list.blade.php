@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitmanage.outstorageroom.oustorageapply')}}">查询</a></li>
                        <li><a href="javascript:void(0)" onclick="apply_submit()">提交申请</a></li>
                        <li><a href="javascript:void(0)" onclick="export_xls()">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.oustorageapply')}}">打印</a></li>
                        <li ><a href="{{route('admin.exhibitmanage.outstorageroom.add_oustorageapply')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitmanage.outstorageroom.oustorageapply')}}">
                            <div class="form-group">
                                <input type="text" name="executer" placeholder="经办人" class="form-control" value="{{request('title')}}">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitmanage.outstorageroom.oustorageapply')}}'">重置</button>
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
                                <th>申请部门名称</th>
                                <th>经办人</th>
                                <th>联系人</th>
                                <th>联系方式</th>
                                <th>出库时间</th>
                                <th>出库目的</th>
                                <th>展品列表</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="checkbox" name="exhibit_used_apply_id" value="{{$exhibit['exhibit_used_apply_id']}}"></td>
                                    <td>{{$exhibit['apply_depart_name']}}</td>
                                    <td>{{$exhibit['executer']}}</td>
                                    <td>{{$exhibit['connectioner']}}</td>
                                    <td>{{$exhibit['phone']}} </td>
                                    <td>{{$exhibit['outer_time']}} </td>
                                    <td>{{$exhibit['outer_destination']}} </td>
                                    <td>{{$exhibit['exhibit_names']}} </td>
                                    <td>{{\App\Dao\ConstDao::$exhibit_used_apply_desc[$exhibit['status']]}} </td>
                                    <td>
                                        @if($exhibit['status'] == \App\Dao\ConstDao::EXHIBIT_USED_APPLY_STATUS_DRAFT)
                                            <a href="{{route('admin.exhibitmanage.outstorageroom.add_oustorageapply')."?exhibit_used_apply_id=".$exhibit['exhibit_used_apply_id']}}">修改</a> |
                                            <a href="">删除</a>
                                        @endif
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
        checkd_list = $('input[name="exhibit_used_apply_id"]:checked')
        collect_apply_ids = []
        for(i = 0; i<checkd_list.length;i++){
            collect_apply_ids.push($(checkd_list[i]).val())
        }
        return collect_apply_ids;
    }

    /**
     * 提交审核
     */
    function apply_submit() {
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        $.ajax('{{route("admin.exhibitmanage.outstorageroom.oustorageapply_submit")}}', {
            method: 'POST',
            data: {'exhibit_used_apply_id':collect_apply_ids},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();", 3000)
        });
    }
    
    function export_xls() {
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        url = '{{route("admin.excel.export_outer_apply")."?"}}'
        for(i=0;i<collect_apply_ids.length;i++){
            url += 'exhibit_used_apply_id['+i.toString()+']='+collect_apply_ids[i]+"&";
        }
        window.open(url);
    }
</script>

