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
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover">
                            <tr class="gradeA">
                                <th>展品总登记号</th>
                                <th>展品名称</th>
                                <th>操作</th>
                            </tr>
                            @foreach($list as $k => $v)
                                <tr class="gradeA">
                                    <td>{{$v['exhibit_sum_register_num']}}</td>
                                    <td>{{$v['name']}}</td>
                                    <td><input type="checkbox" name="exhibit_sum_register_id"
                                               @if($v['is_checked'])
                                                       checked
                                               @endif
                                               value="{{$v['exhibit_sum_register_id']}}"> </td>
                                </tr>
                            @endforeach
                        </table>
                        <button class="btn btn-primary" onclick="do_submit()">保存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    var show_position_id = "{{$info['show_position_id']}}";
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
     * 提交审核
     */
    function do_submit() {
        collect_apply_ids = get_collect_checked_ids();
        if(collect_apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        $.ajax('{{route("admin.exhibitshow.position_relative_save")}}', {
            method: 'POST',
            data: {'show_position_id':show_position_id,'exhibit_sum_register_id':collect_apply_ids,'_token':"{{csrf_token()}}"},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();", 3000)
        });
    }

</script>