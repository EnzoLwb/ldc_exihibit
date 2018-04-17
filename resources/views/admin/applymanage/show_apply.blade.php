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
                            <li><a href="javascript:void(0)" onclick="apply_audit('{{\App\Dao\ConstDao::SHOW_APPLY_STATUS_AUDITED}}')">审核通过</a></li>
                            <li><a href="javascript:void(0)" onclick="apply_audit({{\App\Dao\ConstDao::SHOW_APPLY_STATUS_REFUSE}})">审核拒绝</a></li>
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
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover">
                            <tr class="gradeA">
                                @if(empty($show))<th>选择</th>@endif
                                <th>申请人</th>
                                <th>申请时间</th>
                                <th>展览主题</th>
                                <th>参展人员</th>
                                <th>展览编号</th>
                                @if(!empty($show))<th>状态</th>@endif
                                <th>展览开始日期</th>
                                <th>展览结束日期</th>

                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    @if(empty($show))
                                        <td><input type="checkbox" name="show_apply_id" value="{{$v['show_apply_id']}}"></td>
                                    @endif
                                    <td>{{$v['applyer']}}</td>
                                    <td>{{$v['apply_time']}}</td>
                                    <td>{{$v['theme']}}</td>
                                    <td>{{$v['exhibitor']}}</td>
                                    <td>{{$v['show_num']}}</td>
                                    @if(!empty($show))
                                        <td>{{\App\Dao\ConstDao::$show_apply_desc[$v['status']]}}</td>
                                    @endif
                                    <td>{{$v['start_date']}}</td>
                                    <td>{{$v['end_date']}}</td>

                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <div>共 {{ $data->total() }} 条记录</div>
                                {!! $data->links() !!}
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
        checkd_list = $('input[name="show_apply_id"]:checked')
        collect_apply_ids = []
        for(i = 0; i<checkd_list.length;i++){
            collect_apply_ids.push($(checkd_list[i]).val())
        }
        return collect_apply_ids;
    }

    /**
     * 提交审核
     */
    function apply_audit(audited) {
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        $.ajax('{{route("admin.applymanage.show_audit")}}', {
            method: 'POST',
            data: {'show_apply_id':collect_apply_ids,"_token":"{{csrf_token()}}",'audit':audited},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload()",3000);
        });
    }
</script>

