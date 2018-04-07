@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
                            <thead>
                            <tr role="row">
                                <th>鉴定人</th>
                                <th>展品信息</th>
                                <th>鉴定成果</th>
                                <th>名称</th>
                                <th>年代</th>
                                <th>藏品级别</th>
                                <th>藏品类别</th>
                                <th>藏品质地</th>
                                <th>完残程度</th>

                            </tr>
                            </thead>
                            @foreach($list as $exhibit)
                                <tr class="gradeA">
                                    <td>{{$exhibit['username']}}</td>
                                    <td>{{$exhibit['exhibit_name']}}</td>
                                    <td>{{$exhibit['identify_result']}}</td>
                                    <td>{{$exhibit['name']}}</td>
                                    <td>{{$exhibit['age']}}</td>
                                    <td>{{$exhibit['exhibit_level']}}</td>
                                    <td>{{$exhibit['type']}}</td>
                                    <td>{{$exhibit['quality']}}</td>
                                    <td>{{$exhibit['complete_degree']}}</td>

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