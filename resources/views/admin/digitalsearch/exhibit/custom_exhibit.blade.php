@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('head')
<style>
    .cell_one{ margin-bottom: 10px;}
.otheropt{ text-align: center;}
a.otheropt{ display: inline-block; height: 34px; margin-left: 10px; margin-right: 30px; position: relative; font-size: 14px; line-height: 34px;}
a.otheropt:after{ display: block; content: "\f107"; width: 16px; height: 16px; position: absolute; top: 0px; right: -17px;}
a.otheropt.on:after{ content: "\f106";}
.otheropt_list{ display: none; width: 100%; height: auto; margin-bottom: 20px; padding: 10px 0 0; background-color: #eee;}
.otheropt_list .cell{ display: inline-block; width: 320px; margin-bottom: 10px;}
.cell_one label,
.otheropt_list .cell label{ width: 120px; padding-right: 5px; text-align: right;}
.otheropt_list .cell input,
.otheropt_list .cell select{ width: 180px;}
</style>
@endsection

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
                        <form role="form" class="form-inline" method="get" action="{{route('admin.digitalsearch.custom_exhibit')}}">
                            <div class="cell_one">
                                <label>总登记号</label>
                                <input name="exhibit_sum_register_num" value="{{request('exhibit_sum_register_num')}}" class="form-control">
                                <label>名称</label>
                                <input name="name" value="{{request('name')}}" class="form-control">
                                <a class="otheropt fa">其他选项</a>
                                <button type="submit" class="btn btn-primary">搜索</button>
                            </div>
                            <div class="otheropt_list">
                                <div class="cell">
                                    <label>收藏单位名称</label>
                                    <input name="collect_depart_name" value="{{request('collect_depart_name')}}" class="form-control">
                                </div>
                                <div class="cell">
                                    <label>具体年代</label>
                                    <input name="age" value="{{request('age')}}" class="form-control">
                                </div>
                                <div class="cell">
                                    <label>具体质地</label>
                                    <input name="textaure" value="{{request('textaure')}}" class="form-control">
                                </div>
                                <div class="cell">
                                    <label>具体类别</label>
                                    <input name="type" value="{{request('type')}}" class="form-control">
                                </div>
                                <div class="cell">
                                    <label>实际数量</label>
                                    <input name="num" value="{{request('num')}}" class="form-control">
                                </div>
                                <div class="cell">
                                    <label>具体质量</label>
                                    <input name="quality" value="{{request('quality')}}" class="form-control">
                                </div>
                                <div class="cell">
                                    <label>级别</label>
                                    <select name="exhibit_level" class="form-control">
                                        <option value="" @if(empty(request('exhibit_level'))) selected @endif>全部级别</option>
                                        @foreach(\App\Dao\ConstDao::$exhibit_level_desc as $k=>$v)
                                            <option @if(request('exhibit_level') == $k) selected @endif value="{{$k}}">{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="cell">
                                    <label>来源</label>
                                    <input name="src" value="{{request('src')}}" class="form-control">
                                </div>
                                <div class="cell">
                                    <label>完残状况</label>
                                    <input name="complete_info" value="{{request('complete_info')}}" class="form-control">
                                </div>
                                <div class="cell">
                                    <label>保存状态</label>
                                    <input name="storage_status" value="{{request('storage_status')}}" class="form-control">
                                </div>
                                <div class="cell">
                                    <label>入藏时间</label>
                                    <input name="created_at" value="{{request('created_at')}}" class="form-control">
                                </div>
                                <div class="cell">
                                    <label>状态</label>
                                    <select name="status" class="form-control">
                                        <option  value="{{\App\Dao\ConstDao::EXHIBIT_STATUS_IN_ROOM}}">在库</option>
                                        <option  value="{{'-1'.\App\Dao\ConstDao::EXHIBIT_STATUS_IN_ROOM}}">非在库</option>
                                    </select>
                                </div>
                                <div class="cell">
                                    <label>原展厅具体位置</label>
                                    <input name="ori_storage_position" value="{{request('ori_storage_position')}}" class="form-control">
                                </div>
                                <div class="cell">
                                    <label>展厅柜号</label>
                                    <input name="room_gui_num" value="{{request('room_gui_num')}}" class="form-control">
                                </div>
                                <div class="cell">
                                    <label>藏品性质</label>
                                    <input name="exhibit_property" value="{{request('exhibit_property')}}" class="form-control">
                                </div>
                                <div class="cell">
                                    <label>注销凭证号</label>
                                    <input name="exhibit_property" value="{{request('exhibit_property')}}" class="form-control">
                                </div>
                                <div class="cell">
                                    <label>备注</label>
                                    <input name="backup" value="{{request('backup')}}" class="form-control">
                                </div>
                            </div>

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

@section('script')
<script>
    $(".otheropt").click(function(){
        $(".otheropt").toggleClass("on");
        $(".otheropt_list").slideToggle();
    });

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
@endsection


