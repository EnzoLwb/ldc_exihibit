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
                            <li><a href="javascript:void(0)" onclick="examine('pass')">审核通过</a></li>
                            <li><a href="javascript:void(0)" onclick="examine('refuse')">审核拒绝</a></li>
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
                                <th>库房编号</th>
                                <th>计划盘点人员</th>
                                <th>计划盘点日期</th>
                                <th>盘点文物数量</th>
                                @if(!empty($show))<th>状态</th>@endif
                                <th>盘点状态</th>
                                <th>备注</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $v)
                                <tr class="gradeA">
                                    @if(empty($show))
                                        <td> <input type="checkbox" name="check_id" value="{{$v['check_id']}}"></td>
                                    @endif
                                    <td>{{$v['room_number']}}</td>
                                    <td>{{$v['plan_member']}}</td>
                                    <td>{{$v['plan_date']}}</td>
                                    <td>{{$v['goods_count']}}</td>
                                    @if(!empty($show))
                                        <td>{{$v->applyStatus($v['apply_status'])}}</td>
                                    @endif
                                    <td>{{$v->checkStatus($v['check_status'])}}</td>
                                    <td width="20%">{{$v['apply_remark']}}</td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <div style="text-align: right">共 {{ $exhibit_list->total() }} 条记录</div>
                                <div style="text-align: center">{!! $exhibit_list->links() !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    //功能函数，收集选中项
    function get_collect_checked_ids() {
        checkd_list = $('input[name="check_id"]:checked')
        collect_apply_ids = []
        for(i = 0; i<checkd_list.length;i++){
            collect_apply_ids.push($(checkd_list[i]).val())
        }
        return collect_apply_ids;
    }

    /**
     * 审核通过
     */
    function examine(type) {
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        status = type=='pass'?'1': '0';
        $.ajax('{{route("admin.applymanage.storageCheck_apply")}}', {
            method: 'POST',
            data: {'apply_type':status,'storageCheck_apply_ids':collect_apply_ids,"_token":"{{csrf_token()}}"},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();", 3000)
        });
    }

</script>

