@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitshow.show')}}">展品展览</a></li>
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
                                <th>展位编号</th>
                                <th>展位名称</th>
                                <th>展品名称</th>
                                <th>操作</th>
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
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
</script>