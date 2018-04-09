@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitmanage.accidentregistration')}}">查询</a></li>
                        <li><a href="javascript:void(0)" onclick="do_submit()">提交</a></li>
                        <li><a href="javascript:VOID(0)" onclick="export_xls()">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.accidentregistration')}}">打印</a></li>
                        <li ><a href="{{route('admin.exhibitmanage.add_accidentregistration')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitmanage.disinfection')}}">
                            <div class="form-group">
                                <input type="text" name="title" placeholder="文物名称" class="form-control" value="{{request('title')}}">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitmanage.disinfection')}}'">重置</button>
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
                                <th>文物名称</th>
                                <th>总登记号</th>
                                <th>事故时间</th>
                                <th>事故人</th>
                                <th>事故描述</th>
                                <th>处理依据</th>
                                <th>处理意见</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="checkbox" name="accident_id" value="{{$exhibit['accident_id']}}"></td>
                                    <td>{{$exhibit['name']}}</td>
                                    <td>{{$exhibit['exhibit_sum_register_num']}}</td>
                                    <td>{{$exhibit['accident_time']}}</td>
                                    <td>{{$exhibit['accident_maker']}} </td>
                                    <td>{{$exhibit['accident_desc']}} </td>
                                    <td>{{$exhibit['proc_dependy']}} </td>
                                    <td>{{$exhibit['proc_suggestion']}} </td>
                                    <td>{{\App\Dao\ConstDao::$accident_desc[$exhibit['status']]}} </td>
                                    <td>
                                        @if($exhibit['status'] == \App\Dao\ConstDao::ACCIDENT_STATUS_DRAFT)
                                        <a href="{{route('admin.exhibitmanage.add_accidentregistration')."?accident_id=".$exhibit['accident_id']}}">修改</a> <a href="javascript:void(0)" onclick="del_accident()">删除</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <div>共 {{ $exhibit_list->total() }} 条记录</div>
                                {!! $exhibit_list->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    //功能函数，收集选中的申请项
    function get_collect_checked_ids() {
        checkd_list = $('input[name="accident_id"]:checked')
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
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        $.ajax('{{route("admin.exhibitmanage.accidentregistration_submit")}}', {
            method: 'POST',
            data: {'accident_id':collect_apply_ids,"_token":"{{csrf_token()}}"},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload()",3000);
        });
    }

    function export_xls() {
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        url = "{{route('admin.excel.export_accident').'?'}}";
        for(i=0;i<collect_apply_ids.length;i++){
            url += 'accident_id['+i.toString()+"]="+collect_apply_ids[i]+"&";
        }
        window.open(url);
    }
</script>

