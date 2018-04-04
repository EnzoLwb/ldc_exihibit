@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitcollect.getin')}}">查询</a></li>
                        <li><a href="javascript:void(0)" onclick="submit_item()">提交</a></li>
                        <li><a href="javscript:void(0)" onclick="export_xls()">导出</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">图文模式</a></li>
                        <li ><a href="{{route('admin.exhibitcollect.getin_add').'?operation='.\App\Dao\ConstDao::OPERATION_ADD}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitcollect.getin')}}">
                            <select class="form-control" name="type">
                                <option value="{{\App\Dao\ConstDao::EXHIBIT_COLLECT_RECIPE_SRC_BY_APPLY}}">征集入馆</option>
                                <option value="{{\App\Dao\ConstDao::EXHIBIT_COLLECT_RECIPE_SRC_BY_DIRECT}}">直接入馆</option>
                            </select>
                            <button type="submit" class="btn btn-primary">查询</button>
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
                                <th>入馆凭证号</th>
                                <th>入馆凭证名称</th>
                                <th>入馆日期</th>
                                <th>收据号</th>
                                <th>备注</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="checkbox" name="collect_recipe_id" value="{{$exhibit['collect_recipe_id']}}"></td>
                                    <td>{{$exhibit['collect_recipe_num']}}
                                    </td>
                                    <td>{{$exhibit['collect_recipe_name']}}
                                    </td>
                                    <td>{{$exhibit['collect_date']}}
                                    </td>
                                    <td>{{$exhibit['recipe_num']}}
                                    </td>
                                    <td>{{$exhibit['mark']}}
                                    </td>
                                    <td>
                                        @if($exhibit['status'] == \App\Dao\ConstDao::EXHIBIT_COLLECT_RECIPE_STATUS_SUBMITED)
                                            <a href="{{route("admin.exhibitcollect.getin_add")."?operation=".\App\Dao\ConstDao::OPERATION_VIEW."&collect_recipe_id=".$exhibit['collect_recipe_id']}}">查看</a>
                                        @else
                                            <a href="{{route("admin.exhibitcollect.getin_add")."?operation=".\App\Dao\ConstDao::OPERATION_EDIT."&collect_recipe_id=".$exhibit['collect_recipe_id']}}">修改</a>
                                            <a href="">删除</a>
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
@endsection
<script>
    //功能函数，收集选中的申请项
    function get_collect_checked_ids() {
        checkd_list = $('input[name="collect_recipe_id"]:checked')
        collect_apply_ids = []
        for(i = 0; i<checkd_list.length;i++){
            collect_apply_ids.push($(checkd_list[i]).val())
        }
        return collect_apply_ids;
    }

    /**
     *导出内容
     */
    function export_xls() {
        apply_ids = get_collect_checked_ids();
        if(apply_ids.length==0){
            layer.alert("请至少选择一项");
            return
        }
        url = '{{route("admin.excel.export_collect_recipe")}}' +"?";
        for(i=0;i<apply_ids.length;i++){
            url += "collect_recipe_ids["+i.toString()+"]="+apply_ids[i];
        }
        window.open(url)
    }

    /**
     * 提交进总账
     */
    function submit_item(){
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        console.log(collect_apply_ids);
        $.ajax({
            url: "{{route('admin.exhibitcollect.into_sum_account')}}",
            type: 'post',
            data: {ids:collect_apply_ids},
            async: false,
            success: function (data) {
                if(!data.status){
                    layer.alert('操作失败，请稍后再试')
                }else{
                    layer.alert('操作成功')
                    setTimeout("location.href.reload()",3000);
                }
            }
        });
    }
</script>

