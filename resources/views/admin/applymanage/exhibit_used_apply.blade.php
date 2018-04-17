@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        @if(empty($show))
                            <li class="active"><a href="{{route('admin.applymanage.export_collect_apply')}}">查询</a></li>
                            <li><a href="javascript:void(0)" onclick="pass()">审核通过</a></li>
                            <li><a href="javascript:void(0)" onclick="refuse()">审核拒绝</a></li>
                            <li><a href="{{route('admin.applymanage.history_apply')}}">历史列表</a></li>
                        @else
                            <li><a href="{{route('admin.applymanage.export_collect_apply')}}">查询</a></li>
                            <li class="active"><a href="{{route('admin.applymanage.history_apply')}}">历史列表</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        @include('layouts.apply')
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
                            <thead>
                            <tr role="row">
                                @if(empty($show))<th>选择</th>@endif
                                <th>申请部门名称</th>
                                <th>经办人</th>
                                <th>联系人</th>
                                <th>联系方式</th>
                                <th>出库时间</th>
                                <th>出库目的</th>
                                @if(!empty($show))<th>状态</th>@endif
                                <th>展品信息</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    @if(empty($show))
                                        <td><input type="checkbox" name="exhibit_used_apply_id" value="{{$exhibit['exhibit_used_apply_id']}}"></td>
                                    @endif
                                    <td>{{$exhibit['apply_depart_name']}}</td>
                                    <td>{{$exhibit['executer']}}</td>
                                    <td>{{$exhibit['connectioner']}}</td>
                                    <td>{{$exhibit['phone']}}</td>
                                    <td>{{$exhibit['outer_time']}}</td>
                                    <td>{{$exhibit['outer_destination']}}</td>
                                    @if(!empty($show))
                                        <td>{{\App\Dao\ConstDao::$exhibit_used_apply_desc[$exhibit['status']]}}</td>
                                    @endif
                                    <td>{{$exhibit['exhibit_names']}}</td>
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
        checkd_list = $('input[name="exhibit_used_apply_id"]:checked')
        collect_apply_ids = []
        for(i = 0; i<checkd_list.length;i++){
            collect_apply_ids.push($(checkd_list[i]).val())
        }
        return collect_apply_ids;
    }

    /**
     * 审核通过
     */
    function pass() {
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        $.ajax('{{route("admin.applymanage.exhibit_outer_pass")}}', {
            method: 'POST',
            data: {'exhibit_use_apply_ids':collect_apply_ids,"_token":"{{csrf_token()}}"},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();", 3000)
        });
    }

    function refuse() {
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        $.ajax('{{route("admin.applymanage.exhibit_outer_refuse")}}', {
            method: 'POST',
            data: {'exhibit_use_apply_ids':collect_apply_ids,"_token":"{{csrf_token()}}"},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();", 3000)
        });
    }

</script>

