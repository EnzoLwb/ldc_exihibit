@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.storageroommanage.frame')}}">查询</a></li>
                        <li><a href="javascript:void(0)" onclick="export_xls()">导出</a></li>
                        <li><a href="javascript:void(0)" >打印</a></li>
                        <li><a href="{{route('admin.storageroommanage.frame.add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.storageroommanage.frame')}}">
                            <div class="form-group">
                                <label class="sr-only">排架名称</label>
                                <input type="text" name="frame_name" placeholder="排架名称" class="form-control" value="{{request('frame_name')}}">
                            </div>
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.storageroommanage.frame')}}'">重置</button>
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
                                <th>库房库位名称</th>
                                <th>排架编号</th>
                                <th>排架名称</th>
                                <th>操作</th>
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    <td>
                                        <input type="checkbox" name="frame_id" value="{{$v['frame_id']}}">
                                    </td>
                                    <td>{{$v['room_name']}}</td>
                                    <td>{{$v['frame_number']}}</td>
                                    <td>{{$v['frame_name']}}</td>
                                    <td>
                                        <a href="{{route('admin.storageroommanage.roomstruct.delete',['room_id'=>$v['room_id']])}}"
                                           onclick="if (confirm('确定要删除此记录吗？')==false) return false">删除</a>
                                        <a href="{{route('admin.storageroommanage.roomstruct.edit',['room_id'=>$v['room_id']])}}">修改</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class=".col-sm-6 .col-sm-offset-3">

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
    function room_struct_ids() {
        checkd_list = $('input[name="frame_id"]:checked')
        logout_ids = []
        for(i = 0; i<checkd_list.length;i++){
            logout_ids.push($(checkd_list[i]).val())
        }
        return logout_ids;
    }

    /**
     *导出内容
     */
    function export_xls() {
        apply_ids = room_struct_ids();
        if(apply_ids.length==0){
            layer.alert("请至少选择一项");
            return
        }
        url = '{{route("admin.excel.export_frame")}}' +"?";
        for(i=0;i<apply_ids.length;i++){
            url += "frame_id["+i.toString()+"]="+apply_ids[i];
        }
        window.open(url)
    }
</script>