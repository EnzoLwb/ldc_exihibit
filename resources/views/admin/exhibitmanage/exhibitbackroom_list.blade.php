@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitmanage.exhibitbackroom')}}">查询</a></li>
                        <li><a href="javascript:void(0)" onclick="do_submit()">提交</a></li>
                        <li><a href="javascript:void(0)" onclick="export_list()">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.exhibitbackroom')}}">打印</a></li>
                        <li ><a href="{{route('admin.exhibitmanage.add_exhibitbackroom')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitmanage.exhibitbackroom')}}">
                            <div class="form-group">
                                <input type="text" name="title" placeholder="文物名称" class="form-control" value="{{request('title')}}">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitmanage.exhibitbackroom')}}'">重置</button>
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
                                <th>退换人</th>
                                <th>点收人</th>
                                <th>退换日期</th>
                                <th>备注</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="checkbox" name="return_storage_id"value="{{$exhibit['return_storage_id']}}"></td>
                                    <td>{{$exhibit['name']}}</td>
                                    <td>{{$exhibit['returner']}}</td>
                                    <td>{{$exhibit['taker']}}</td>
                                    <td>{{$exhibit['return_date']}} </td>
                                    <td>{{$exhibit['mark']}} </td>
                                    <td>
                                        @if($exhibit['status'] == \App\Dao\ConstDao::RETURNSTORAGE_STATUS_DRAFT)
                                            <a href="{{route('admin.exhibitmanage.add_exhibitbackroom').'?return_storage_id='.$exhibit['return_storage_id']}}">
                                                编辑
                                            </a>
                                            <a href="javascript:void(0)" onclick="del_return({{$exhibit['return_storage_id']}})">
                                                删除
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        //功能函数，收集选中的申请项
        function get_collect_checked_ids() {
            checkd_list = $('input[name="return_storage_id"]:checked')
            collect_apply_ids = []
            for(i = 0; i<checkd_list.length;i++){
                collect_apply_ids.push($(checkd_list[i]).val())
            }
            return collect_apply_ids;
        }

        /**
         * 提交审核
         */
        function do_submit() {
            collect_apply_ids = get_collect_checked_ids();
            if(collect_apply_ids.length==0){
                layer.alert("请至少选择一项")
                return
            }
            $.ajax('{{route("admin.exhibitmanage.submit_exhibitbackroom")}}', {
                method: 'POST',
                data: {'return_storage_id':collect_apply_ids,'_token':"{{csrf_token()}}"},
                dataType: 'json'
            }).done(function (response) {
                layer.alert(response.msg)
                setTimeout("location.reload();", 3000)
            });
        }
        /**
         * 导出申请列表
         */
        function export_list() {
            apply_ids = get_collect_checked_ids();
            if(apply_ids.length==0){
                layer.alert("请至少选择一项")
                return
            }
            url = '{{route("admin.excel.export_returnstorage")}}' +"?";
            for(i=0;i<apply_ids.length;i++){
                url += "return_storage_id["+i.toString()+"]="+apply_ids[i]
            }
            window.open(url)
        }
    </script>


@endsection
