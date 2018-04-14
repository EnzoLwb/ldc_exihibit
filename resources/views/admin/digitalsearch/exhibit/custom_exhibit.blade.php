@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.digitalsearch.exhibit')}}">综合查询</a></li>
                        <li class="active"><a href="{{route('admin.digitalsearch.custom_exhibit')}}">自定义查询</a></li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.digitalsearch.exhibit')}}">
                            <div class="form-group">
                                <label>类别</label>
                                <input name="type" value="{{request('type')}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>级别</label>
                                <select name="exhibit_level" class="form-control">
                                    <option value="" @if(empty(request('exhibit_level'))) selected @endif>全部级别</option>
                                    @foreach(\App\Dao\ConstDao::$exhibit_level_desc as $k=>$v)
                                        <option @if(request('exhibit_level') == $k) selected @endif value="{{$k}}">{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
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
                                <th>分类号</th>
                                <th>名称</th>
                                <th>类别</th>
                                <th>年代</th>
                                <th>质量</th>
                                <th>完残情况</th>
                                <th>状态</th>


                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="checkbox" name="fake_exhibit_sum_register_id" value="{{$exhibit['exhibit_sum_register_id']}}"></td>
                                    <td>{{$exhibit['exhibit_sum_register_num']}}</td>
                                    <td>{{$exhibit['type_num']}}</td>
                                    <td>{{$exhibit['name']}}</td>
                                    <td>{{$exhibit['type']}} </td>
                                    <td>{{$exhibit['age']}} </td>
                                    <td>{{$exhibit['quality']}} </td>
                                    <td>{{$exhibit['complete_degree']}} </td>
                                    <td>{{\App\Dao\ConstDao::$exhibit_status_desc[$exhibit['status']]}} </td>

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
        checkd_list = $('input[name="fake_exhibit_sum_register_id"]:checked')
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
        $.ajax('{{route("admin.inforegister.fake_exhibit_submit")}}', {
            method: 'POST',
            data: {'fake_exhibit_sum_register_id':collect_apply_ids},
            dataType: 'json'
        }).done(function (response) {
            layer.alert(response.msg)
            setTimeout("location.reload();", 3000)
        });
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
        url = "{{route('admin.excel.export_fake_exhibit')."?"}}"
        for(i=0;i<collect_apply_ids.length;i++){
            url +="fake_exhibit_sum_register_id["+i.toString()+"]="+collect_apply_ids[i]+"&";
        }
        window.open(url);
    }
</script>


