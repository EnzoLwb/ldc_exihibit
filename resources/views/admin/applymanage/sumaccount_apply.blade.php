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
                            <li><a href="javascript:void(0)" onclick="audit('{{\App\Dao\ConstDao::FAKE_EXHIBIT_STATUS_PASS}}')">审核通过</a></li>
                            <li><a href="javascript:void(0)" onclick="audit('{{\App\Dao\ConstDao::FAKE_EXHIBIT_STATUS_REFUSE}}')">审核拒绝</a></li>
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
                                <th>总登记号</th>
                                <th>分类号</th>
                                <th>名称</th>
                                <th>类别</th>
                                <th>年代</th>
                                <th>质量</th>
                                <th>完残情况</th>
                                @if(!empty($show))<th>状态</th>@endif
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    @if(empty($show))
                                        <td><input type="checkbox" name="fake_exhibit_sum_register_id" value="{{$exhibit['fake_exhibit_sum_register_id']}}"></td>
                                    @endif
                                    <td>{{$exhibit['exhibit_sum_register_num']}}</td>
                                    <td>{{$exhibit['type_num']}}</td>
                                    <td>{{$exhibit['name']}}</td>
                                    <td>{{$exhibit['type']}} </td>
                                    <td>{{$exhibit['age']}} </td>
                                    <td>{{$exhibit['quality']}} </td>
                                    <td>{{$exhibit['complete_degree']}} </td>
                                    @if(!empty($show))
                                        <td>{{\App\Dao\ConstDao::$fake_exhibit_desc[$exhibit['audit_status']]}} </td>
                                    @endif

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
    //功能函数，收集选中项
    function get_collect_checked_ids() {
        checkd_list = $('input[name="fake_exhibit_sum_register_id"]:checked')
        collect_apply_ids = []
        for(i = 0; i<checkd_list.length;i++){
            collect_apply_ids.push($(checkd_list[i]).val())
        }
        return collect_apply_ids;
    }

    /**
     * 审核通过
     */
    function audit(status) {
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        $.ajax('{{route("admin.applymanage.fake_exhibit_audit")}}', {
            method: 'POST',
            data: {'fake_exhibit_sum_register_id':collect_apply_ids,"_token":"{{csrf_token()}}", 'audit_status':status},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();", 3000)
        });
    }

</script>

