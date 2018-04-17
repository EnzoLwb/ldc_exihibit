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
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        @if(empty($show))
                            <li><a href="{{route('admin.applymanage.export_collect_apply',['apply_type'=>'repair'])}}">修复申请</a></li>
                            <li class="active"  ><a href="{{route('admin.applymanage.export_collect_apply',['repair_type'=>'inside','apply_type'=>'repair'])}}">内修文物申请</a></li>
                            <li><a href="{{route('admin.applymanage.export_collect_apply',['repair_type'=>'outside','apply_type'=>'repair'])}}">外修文物申请</a></li>
                        @else
                            <li><a href="{{route('admin.applymanage.history_apply',['apply_type'=>'repair'])}}">修复申请</a></li>
                            <li class="active"  ><a href="{{route('admin.applymanage.history_apply',['repair_type'=>'inside','apply_type'=>'repair'])}}">内修文物申请</a></li>
                            <li><a href="{{route('admin.applymanage.history_apply',['repair_type'=>'outside','apply_type'=>'repair'])}}">外修文物申请</a></li>
                        @endif
                    </ul>
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
                                @if(empty($show))<th>选择</th>@endif
                                <th>档案号</th>
                                <th>藏品名称</th>
                                <th>提取日期</th>
                                <th>归还时间</th>
                                <th>主持人</th>
                                <th>修复人</th>
                                <th>文物现状</th>
                                @if(!empty($show))<th>状态</th>@endif
                                <th>查看</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $v)
                                <tr class="gradeA">
                                    @if(empty($show))
                                        <td>
                                            <input type="checkbox" name="inside_repair_id" value="{{$v['inside_repair_id']}}">
                                        </td>
                                    @endif
                                    <td>{{$v['repair_order_name']}}</td>
                                    <td>{{$v['name']}}</td>
                                    <td>{{$v['pickup_date']}}</td>
                                    <td>{{$v['return_date']}}</td>
                                    <td>{{$v['host']}}</td>
                                    <td>{{$v['restorer']}}</td>
                                    <td>{{$v['exhibit_status']}}</td>
                                    @if(!empty($show))
                                        <td>{{$v->applyStatus($v['apply_status'])}}</td>
                                    @endif
                                    <td>
                                        <a href="{{route('admin.repaireexhibit.repairin.detail',['source'=>'apply','inside_repair_id'=>$v['inside_repair_id']])}}">查看详情</a>
                                    </td>
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
        checkd_list = $('input[name="inside_repair_id"]:checked')
        collect_apply_ids = []
        for(i = 0; i<checkd_list.length;i++){
            collect_apply_ids.push($(checkd_list[i]).val())
        }
        return collect_apply_ids;
    }

    /**
     * 审核
     */
    function examine(type) {
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        status = type=='pass'?'2': '3';
        $.ajax('{{route("admin.applymanage.repair_apply")}}', {
            method: 'POST',
            data: {'apply_type':status,'repair_apply_ids':collect_apply_ids,"_token":"{{csrf_token()}}",'type':'inside'},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();", 3000)
        });
    }
</script>

