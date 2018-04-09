@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">提交</a></li>
                        <li><a href="javascript:void(0)" onclick="export_xls()">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">打印</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitmanage.instorageroom')}}">
                            <div class="form-group">
                                <input type="text" name="title" placeholder="名称" class="form-control" value="{{request('title')}}">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitmanage.instorageroom')}}'">重置</button>
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
                                <th>提供部门</th>
                                <th>出库目的</th>
                                <th>出库日期</th>
                                <th>库房点叫人</th>
                                <th>提取经手人</th>
                                <th>日期</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="checkbox" name="exhibit_use_id" value="{{$exhibit['exhibit_use_id']}}"></td>
                                    <td>{{$exhibit['depart_name']}}</td>
                                    <td>{{$exhibit['outer_destination']}}</td>
                                    <td>{{$exhibit['outer_time']}}</td>
                                    <td>{{$exhibit['outer_sender']}} </td>
                                    <td>{{$exhibit['outer_taker']}} </td>
                                    <td>{{$exhibit['date']}} </td>
                                    <td><a href="{{route('admin.exhibitmanage.outstorageroom.add_exhibitout')."?exhibit_use_id=".$exhibit['exhibit_use_id']}}">修改</a> |
                                        <a href="">删除</a>
                                    </td>
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
    //功能函数，收集选中的申请项
    function get_collect_checked_ids() {
        checkd_list = $('input[name="exhibit_use_id"]:checked')
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
        url = '{{route("admin.excel.export_exhibit_outer")."?"}}'
        for(i=0;i<collect_apply_ids.length;i++){
            url += 'exhibit_use_id['+i.toString()+']='+collect_apply_ids[i]+"&";
        }
        window.open(url);
    }
</script>

