@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.accountmanage.sumaccount')}}">查询</a></li>

                        <li><a href="{{route('admin.accountmanage.sumaccount')}}">总账复核</a></li>

                        <li><a href="javascript:void(0)" onclick="export_xls()">导出</a></li>
                        <li><a href="{{route('admin.accountmanage.sumaccount')}}">打印</a></li>
                        <li><a href="{{route('admin.accountmanage.sumaccount')}}">图文模式</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{url('admin/data/exhibit')}}">
                            <div class="form-group">
                                <input type="text" name="title" placeholder="申请单号" class="form-control" value="{{request('title')}}">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitcollect.apply')}}'">重置</button>
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
                                <th>总登记号</th>
                                <th>原编号</th>
                                <th>名称</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="checkbox" name="exhibit_sum_register_id" value="{{$exhibit['exhibit_sum_register_id']}}"></td>
                                    <td>{{$exhibit['exhibit_sum_register_num']}}</td>
                                    <td>{{$exhibit['ori_num']}}</td>
                                    <td>{{$exhibit['name']}}</td>

                                    <td>{{\App\Dao\ConstDao::$exhibit_status_desc[$exhibit['status']]}} </td>
                                    <td><a href="{{route('admin.accountmanage.view_sumaccount')."?exhibit_sum_register_id=".$exhibit['exhibit_sum_register_id']}}">查看</td>
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
        checkd_list = $('input[name="exhibit_sum_register_id"]:checked')
        collect_apply_ids = []
        for(i = 0; i<checkd_list.length;i++){
            collect_apply_ids.push($(checkd_list[i]).val())
        }
        return collect_apply_ids;
    }
    /**
     * 导出xls表
     */
    function export_xls() {
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        url = "{{route('admin.excel.export_sum_account')."?"}}"
        for(i=0;i<collect_apply_ids.length;i++){
            url +="exhibit_sum_register_id["+i.toString()+"]="+collect_apply_ids[i]+"&";
        }
        window.open(url);
    }
</script>