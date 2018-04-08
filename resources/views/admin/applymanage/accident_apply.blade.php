@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.applymanage.export_collect_apply')}}">查询</a></li>
                        <li><a href="javascript:void(0)" onclick="apply_audit(1)">审核通过</a></li>
                        <li><a href="javascript:void(0)" onclick="apply_audit(0)">审核拒绝</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.applymanage.export_collect_apply')}}">
                            <div class="form-group">
                            <select name="apply_type" class="form-control">
                                @foreach(\App\Dao\ConstDao::$apply_desc as $key=>$v)
                                    @if($type == $key)
                                        <option selected value="{{$key}}">{{$v}}</option>
                                    @else
                                        <option value="{{$key}}">{{$v}}</option>
                                    @endif

                                @endforeach
                            </select>
                    </div>
                    &nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary">搜索</button>
                    <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.applymanage.export_collect_apply')}}'">重置</button>
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
    function apply_audit(audited) {
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        $.ajax('{{route("admin.applymanage.accident_audit")}}', {
            method: 'POST',
            data: {'accident_id':collect_apply_ids,"_token":"{{csrf_token()}}",'audit':audited},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload()",3000);
        });
    }
</script>

