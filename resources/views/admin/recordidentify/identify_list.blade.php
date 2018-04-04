@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitidentify.apply')}}">查询</a></li>

                    </ul>
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
                                <th>登记日期</th>
                                <th>鉴定申请单位名称</th>
                                <th>拟检定日期</th>
                                <th>拟鉴定专家</th>
                                <th>拟鉴定单位</th>
                                <th>状态</th>
                                <th>登记人</th>
                                <th>展品信息</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            @foreach($list as $exhibit)
                                <tr class="gradeA">
                                  <td> <input type="radio" name="identify_ids" value="{{$exhibit['identify_apply_id']}}"></td>
                                    <td>{{$exhibit['register_date']}}</td>
                                    <td>{{$exhibit['identify_apply_depart']}}</td>
                                    <td>{{$exhibit['identify_date']}}</td>
                                    <td>{{$exhibit['identify_expert']}}</td>
                                    <td>{{$exhibit['identify_depart']}}</td>
                                    <td>{{\App\Dao\ConstDao::$identify_desc[$exhibit['status']]}}</td>
                                    <td>{{$exhibit['register']}}</td>
                                    <td>{{$exhibit['exhibit_names']}}</td>
                                    <td>
                                        <a href="{{route('admin.identifyresult.result_list')."?identify_id=".$exhibit['identify_apply_id']}}">查看鉴定结果</a>
                                        <a href="{{route('admin.identifyresult.add_result')."?identify_apply_id=".$exhibit['identify_apply_id']}}">添加鉴定结果</a>
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
    checkd_list = $('input[name="identify_ids"]:checked')
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
    $.ajax('{{route("admin.exhibitidentify.apply_submit")}}', {
        method: 'POST',
        data: {'identify_apply_id':collect_apply_ids,"_token":"{{csrf_token()}}"},
        dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();", 3000)
    });
}

/**
 * 导出申请表
 */
function export_xls() {
    apply_ids = get_collect_checked_ids();
    if(apply_ids.length==0){
        layer.alert("请至少选择一项");
        return
    }
    url = '{{route("admin.excel.export_identify_apply")}}' +"?";
    for(i=0;i<apply_ids.length;i++){
        url += "identify_apply_ids["+i.toString()+"]="+apply_ids[i];
    }
    window.open(url)
}
</script>