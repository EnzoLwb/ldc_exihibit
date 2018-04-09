@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitshow.position')}}">展位管理</a></li>
                        <li><a href="{{route('admin.exhibitshow.position.add')}}">新增</a></li>
                        <li><a href="javascript:void(0)" onclick="change_status(1)">启用</a></li>
                        <li><a href="javascript:void(0)" onclick="change_status(0)">禁用</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get">
                            <div class="form-group">
                                <label class="sr-only">展位名称</label>
                                <input type="text" name="" placeholder="展位名称" class="form-control" value="">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitshow.position')}}'">重置</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover">
                            <tr class="gradeA">
                                <th>选择</th>
                                <th>展位名称</th>
                                <th>展位编码</th>
                                <th>展陈方式</th>
                                <th>是否末级</th>
                                <th>是否生效</th>
                                <th>位置</th>
                                <th>负责人</th>
                                <th>操作</th>
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    <td><input name="show_position_id" value="{{$v['show_position_id']}}" type="checkbox"/></td>
                                    <td>{{$v['name']}}</td>
                                    <td>{{$v['num']}}</td>
                                    <td>{{$v['show_way']}}</td>
                                    <td>{{\App\Dao\ConstDao::$show_position_last_desc[$v['is_last_level']]}}</td>
                                    <td>{{\App\Dao\ConstDao::$show_position_valid_desc[$v['is_valid']]}}</td>
                                    <td>{{$v['position']}}</td>
                                    <td>{{$v['responser']}}</td>
                                    <td>
                                        <a href="{{route('admin.exhibitshow.position.add')."?show_position_id=".$v['show_position_id']}}">编辑</a>
                                        <a href="javascript:void(0)" onclick="del_position({{$v['show_position_id']}})">删除</a>
                                    </td>
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
        checkd_list = $('input[name="show_position_id"]:checked')
        collect_apply_ids = []
        for(i = 0; i<checkd_list.length;i++){
            collect_apply_ids.push($(checkd_list[i]).val())
        }
        return collect_apply_ids;
    }

    /**
     * 提交审核
     */
    function change_status(status) {
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        $.ajax('{{route("admin.exhibitshow.position.status_change")}}', {
            method: 'POST',
            data: {'show_position_id':collect_apply_ids,"_token":"{{csrf_token()}}",'status':status},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();", 3000)
        });
    }

    function del_position(id) {
        layer.confirm('确认要重启吗?', { btn : [ '确定', '取消' ] }, function(index) {
            $.ajax('{{route("admin.exhibitshow.position.delete")}}', {
                method: 'POST',
                data: {'show_position_id':id,"_token":"{{csrf_token()}}"},
                dataType: 'json'
            }).done(function (response) {
                layer.alert(response.msg)
                setTimeout("location.reload();", 3000)
            });
        });
    }
</script>

