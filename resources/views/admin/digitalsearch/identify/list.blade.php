@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="javascript:void(0)" onclick="export_xls()">导出</a></li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.digitalsearch.identify')}}">
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
                            <div class="form-group">
                                <label>质地</label>
                                <input name="textaure" value="{{request('textaure')}}" class="form-control">
                            </div>
                            &nbsp;&nbsp;
                            <div class="form-group">
                                <label>完残程度</label>
                                <input name="complete_degree" value="{{request('complete_degree')}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>专家专业</label>
                                <input name="profession_skills" value="{{request('profession_skills')}}" class="form-control">
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
                                <th>藏品名称</th>
                                <th>藏品类别</th>
                                <th>藏品质地</th>
                                <th>藏品级别</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="checkbox" name="exhibit_sum_register_id"  value="{{$exhibit['exhibit_sum_register_id']}}"></td>
                                    <td>{{$exhibit['name']}}</td>
                                    <td>{{$exhibit['type']}}</td>
                                    <td>{{$exhibit['textaure']}}</td>
                                    <td>{{\App\Dao\ConstDao::$exhibit_level_desc[$exhibit['exhibit_level']]}}</td>
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
        checkd_list = $('input[name="exhibit_sum_register_id"]:checked')
        collect_apply_ids = []
        for(i = 0; i<checkd_list.length;i++){
            collect_apply_ids.push($(checkd_list[i]).val())
        }
        return collect_apply_ids;
    }

    /**
     * 导出申请列表
     */
    function export_xls() {
        apply_ids = get_collect_checked_ids();
        if(apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        url = '{{route("admin.excel.export_sum_account")}}' +"?";
        for(i=0;i<apply_ids.length;i++){
            url += "exhibit_sum_register_id["+i.toString()+"]="+apply_ids[i]
        }
        console.log(url);
        location.href=url
    }
</script>