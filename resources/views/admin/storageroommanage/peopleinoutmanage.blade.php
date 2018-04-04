@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.storageroommanage.peopleinoutmanage')}}">查询</a></li>
                        <li><a href="javascript:void(0)" onclick="export_list()">导出</a></li>
                        <li><a href="javascript:void(0)" onclick="do_print()">打印</a></li>
                        <li ><a href="{{route('admin.storageroommanage.peopleinoutmanage.add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.storageroommanage.peopleinoutmanage')}}">
                            <div class="form-group">
                                <label class="sr-only">库房编号</label>
                                <input type="text" name="storeroom_id" placeholder="库房编号" class="form-control" value="">
{{--                                <input type="hidden" value="{{csrf_token()}}">--}}
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.storageroommanage.peopleinoutmanage')}}'">重置</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover">
                            <tr class="gradeA">
                                <th>选择</th>
                                <th>库房编号</th>
                                <th>入库时间</th>
                                <th>计划出库时间</th>
                                <th>实际出库时间</th>
                                <th>入库人员</th>
                                <th>陪同人员</th>
                                <th>进库人单位</th>
                                <th>出入事由</th>
                                <th>备注</th>
                                <th>操作</th>
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    <td>
                                        <input type="checkbox" name="logout_id" value="{{$v['pio_id']}}">
                                    </td>
                                    <td>{{$v['storeroom_id']}}</td>
                                    <td>{{$v['comein_time']}}</td>
                                    <td>{{$v['plan_goout_time']}}</td>
                                    <td>{{$v['real_goout_time']}}</td>
                                    <td>{{$v['comein_member']}}</td>
                                    <td>{{$v['with_member']}}</td>
                                    <td>{{$v['comein_department']}}</td>
                                    <td>{{$v['reason']}}</td>
                                    <td width="20%">{{$v['remark']}}</td>
                                    <td>
                                        <a href="{{route('admin.storageroommanage.peopleinoutmanage.delete',['pio_id'=>$v['pio_id']])}}"
                                        onclick="if (confirm('确定要删除此记录吗？')==false) return false">删除</a>
                                        <a href="{{route('admin.storageroommanage.peopleinoutmanage.edit',['pio_id'=>$v['pio_id']])}}">修改</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class=".col-sm-6 .col-sm-offset-3">
                                    <div style="text-align: right">共 {{ $data->total() }} 条记录</div>
                                    <div style="text-align: center">{!! $data->links() !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    //打印功能
    function do_print() {
        window.document.body.innerHTML==window.document.body.innerHTML; //把需要打印的指定内容赋给body.innerHTML
        window.print(); //调用浏览器的打印功能打印指定区域
    }

    //功能函数，收集选中的申请项
    function get_inout_ids() {
        checkd_list = $('input[name="logout_id"]:checked')
        logout_ids = []
        for(i = 0; i<checkd_list.length;i++){
            logout_ids.push($(checkd_list[i]).val())
        }
        return logout_ids;
    }

    /**
     * 导出申请列表
     */
    function export_list() {
        apply_ids = get_inout_ids();
        if(apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        url = '{{route("admin.storageroommanage.peopleinoutmanage.excel")}}' +"?";
        for(i=0;i<apply_ids.length;i++){
            url += "apply_ids["+i.toString()+"]="+apply_ids[i]+"&"
        }
        location.href=url
    }
</script>
