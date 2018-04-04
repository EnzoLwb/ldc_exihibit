@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.storageroommanage.roomenv')}}">查询</a></li>
                        <li><a href="javascript:void(0)" onclick="export_list()">导出</a></li>
                        <li><a href="javascript:void(0)" onclick="do_print()">打印</a></li>
                        <li ><a href="{{route('admin.storageroommanage.roomenv.add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get">
                            <div class="form-group">
                                <label class="sr-only">库房编号</label>
                                <input type="text" name="room_number" placeholder="库房编号" class="form-control" value="">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.storageroommanage.roomenv')}}'">重置</button>
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
                                <th>库房温度</th>
                                <th>库房湿度</th>
                                <th>空气净化程度</th>
                                <th>库房光照率</th>
                                <th>登记人</th>
                                <th>登记日期</th>
                                <th>备注</th>
                                <th>操作</th>
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    <td>
                                        <input type="checkbox" name="logout_id" value="{{$v['book_id']}}">
                                    </td>
                                    <td>{{$v['room_number']}}</td>
                                    <td>{{$v['temp']}}</td>
                                    <td>{{$v['damp']}}</td>
                                    <td>{{$v['air']}}</td>
                                    <td>{{$v['light']}}</td>
                                    <td>{{$v['booker']}}</td>
                                    <td>{{$v['book_time']}}</td>
                                    <td width="20%">{{$v['remark']}}</td>
                                    <td>
                                        <a href="{{route('admin.storageroommanage.roomenv.delete',['book_id'=>$v['book_id']])}}"
                                           onclick="if (confirm('确定要删除此记录吗？')==false) return false">删除</a>
                                        <a href="{{route('admin.storageroommanage.roomenv.edit',['book_id'=>$v['book_id']])}}">修改</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <div style="text-align: right">共 {{ $data->total() }} 条记录</div>
                                <div style="text-align: center">{!! $data->links() !!}</div>
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
    function room_env_ids() {
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
        apply_ids = room_env_ids();
        if(apply_ids.length==0){
            layer.alert("请至少选择一项")
            return
        }
        url = '{{route("admin.storageroommanage.roomenv.excel")}}' +"?";
        for(i=0;i<apply_ids.length;i++){
            url += "apply_ids["+i.toString()+"]="+apply_ids[i]+"&"
        }
        location.href=url
    }
</script>
