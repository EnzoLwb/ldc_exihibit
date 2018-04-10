@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">
@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.applymanage.export_collect_apply')}}">查询</a></li>
                        <li><a href="javascript:void(0)" onclick="examine('pass')">审核通过</a></li>
                        <li><a href="javascript:void(0)" onclick="examine('refuse')">审核拒绝</a></li>
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
                                <th>收藏单位</th>
                                <th>图片</th>
                                <th>分类</th>
                                <th>总登记号</th>
                                <th>分类号</th>
                                <th>入馆登记号</th>
                                <th>申请状态</th>
                                <th>名称</th>
                                <th>原名</th>
                                <th>年代类型</th>
                                <th>具体年代</th>
                                <th>历史阶段</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td>
                                        <input type="checkbox" name="subsidiary_id" value="{{$exhibit['subsidiary_id']}}">
                                    </td>
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
                                    <td>{{$exhibit->applyStatus($exhibit['apply_status'])}}</td>
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

