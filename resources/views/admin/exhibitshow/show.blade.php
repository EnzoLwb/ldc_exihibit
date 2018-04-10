@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitshow.show')}}">展品展览</a></li>
                        <li ><a href="javascript:void(0)" onclick="export_xls()">导出</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitshow.show')}}">
                            <div class="form-group">
                                <label class="sr-only">展位编号</label>
                                <input type="text" name="title" placeholder="展位名称" class="form-control" value="{{request('title')}}">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitshow.show')}}'">重置</button>
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
                                <th>展位编号</th>
                                <th>展位名称</th>
                                <th>展品名称</th>
                                <th>操作</th>
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    <td><input type="checkbox" value="{{$v['show_position_id']}}" name="show_position_id"></td>
                                    <td>{{$v['num']}}</td>
                                    <td>{{$v['name']}}</td>
                                    <td>{{$v['names']}}</td>
                                    <td>
                                        <a target="_blank"href="{{route('admin.exhibitshow.position_relative')."?show_position_id=".$v['show_position_id']}}">编辑</a>
                                        <a href="javascript:void(0)" onclick="clear_relative('{{$v['show_position_id']}}')">解除关联关系</a>
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
    /**
     * 解除该展位对应的展品
     * @param show_position_id
     */
    function clear_relative(show_position_id) {
        $.ajax('{{route("admin.exhibitshow.position_relative_clear")}}', {
            method: 'POST',
            data: {'show_position_id':show_position_id},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();", 3000)
        });
    }

    //功能函数，收集选中的申请项
    function get_collect_checked_ids() {
        checkd_list = $('input[name="show_position_id"]:checked')
        collect_apply_ids = []
        for(i = 0; i<checkd_list.length;i++){
            collect_apply_ids.push($(checkd_list[i]).val())
        }
        return collect_apply_ids;
    }
    function export_xls() {
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        url = "{{route('admin.excel.export_show_position')."?"}}";
        for(i=0;i<collect_apply_ids.length;i++){
            url += "show_position_id["+i.toString()+"]="+collect_apply_ids[i]+"&";
        }
        window.open(url);
    }
</script>