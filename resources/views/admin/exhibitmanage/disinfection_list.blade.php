@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitmanage.disinfection')}}">查询</a></li>
                        <li><a href="javascript:void(0)" onclick="export_disinfection()">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.disinfection')}}">打印</a></li>
                        <li><a href="javascript:void(0)" onclick="del_disinfection()">删除</a></li>
                        <li ><a href="{{route('admin.exhibitmanage.add_disinfection')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitmanage.disinfection')}}">
                            <div class="form-group">
                                <input type="text" name="title" placeholder="藏品名称" class="form-control" value="{{request('title')}}">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitmanage.disinfection')}}'">重置</button>
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
                                <th>藏品名称</th>
                                <th>总登记号</th>
                                <th>清洁方式</th>
                                <th>消毒方式</th>
                                <th>清洁日期</th>

                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="checkbox" name="disinfection_id" value="{{$exhibit['disinfection_id']}}"></td>
                                    <td>{{$exhibit['name']}}</td>
                                    <td>{{$exhibit['exhibit_sum_register_num']}}</td>
                                    <td>{{$exhibit['clean_way']}}</td>
                                    <td>{{$exhibit['disinfection_way']}} </td>
                                    <td>{{$exhibit['clean_date']}} </td>

                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                {!! $paginator->render() !!}
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
        checkd_list = $('input[name="disinfection_id"]:checked')
        collect_apply_ids = []
        for(i = 0; i<checkd_list.length;i++){
            collect_apply_ids.push($(checkd_list[i]).val())
        }
        return collect_apply_ids;
    }

    function del_disinfection() {
        ids = get_collect_checked_ids();
        if(ids.length==0){
            layer.alert('抱歉，请至少选择一项');
            return
        }
        layer.confirm('确认要删除吗？', {
            btn : [ '确定', '取消' ]//按钮
        }, function(index) {
            $.ajax('{{route("admin.exhibitmanage.del_disinfection")}}', {
                method: 'POST',
                data: {'disinfection_id':ids,"_token":"{{csrf_token()}}"},
                dataType: 'json'
            }).done(function (response) {
                if(response.status){
                    layer.alert(response.msg)
                    setTimeout("location.reload();", 3000)
                }else{
                    layer.alert(response.msg)
                }

            });
        });
    }


    function export_disinfection() {
        ids = get_collect_checked_ids();
        if(ids.length==0){
            layer.alert('抱歉，请至少选择一项');
            return
        }
        url = "{{route("admin.excel.export_disinfection")."?"}}";
        for(i=0;i<ids.length;i++){
            url += "disinfection_id["+i.toString()+"]="+ids[i];
        }
        window.open(url);
    }

</script>


