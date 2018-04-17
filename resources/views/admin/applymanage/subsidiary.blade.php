@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">
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
                                <th>收藏单位</th>
                                <th>图片</th>
                                <th>分类</th>
                                <th>总登记号</th>
                                <th>分类号</th>
                                <th>入馆登记号</th>
                                @if(!empty($show))<th>申请状态</th>@endif
                                <th>名称</th>
                                <th>原名</th>
                                <th>年代类型</th>
                                <th>具体年代</th>
                                <th>历史阶段</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    @if(empty($show))
                                        <td>
                                            <input type="checkbox" name="subsidiary_id" value="{{$exhibit['subsidiary_id']}}">
                                        </td>
                                    @endif
                                    <td>{{$exhibit['collect_depart']}}</td>
                                    <td>
                                        @if($exhibit['attachment']!='')
                                            <div class="img-div">
                                                <img src="{{get_file_url($exhibit['attachment'])}}"/>
                                            </div>
                                        @else
                                            <span>暂无附件图片</span>
                                        @endif
                                    </td>
                                    <td>{{$exhibit->typeName($exhibit['type'])}}</td>
                                    <td>{{$exhibit['exhibit_sum_register_num']}}</td>
                                    <td>{{$exhibit['type_num']}}</td>
                                    <td>{{$exhibit['collect_recipe_num']}} </td>
                                    @if(!empty($show))
                                        <td>{{$exhibit->applyStatus($exhibit['apply_status'])}}</td>
                                    @endif
                                    <td>{{$exhibit['name']}} </td>
                                    <td>{{$exhibit['ori_name']}} </td>
                                    <td>{{$exhibit['age_type']}} </td>
                                    <td>{{$exhibit['age']}} </td>
                                    <td>{{$exhibit['history_step']}} </td>
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
        checkd_list = $('input[name="subsidiary_id"]:checked')
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
        status = type=='pass'?'2': '3';//2 为通过 3为拒绝
        $.ajax('{{route("admin.applymanage.subsidiary_apply")}}', {
            method: 'POST',
            data: {'apply_type':status,'subsidiary_apply_ids':collect_apply_ids,"_token":"{{csrf_token()}}"},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();", 3000)
        });
    }

</script>

