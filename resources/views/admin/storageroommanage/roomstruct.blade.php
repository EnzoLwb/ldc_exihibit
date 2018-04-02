@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.storageroommanage.roomstruct')}}">库房结构管理</a></li>
                        <li><a href="{{route('admin.storageroommanage.roomstruct.add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.storageroommanage.roomstruct')}}">
                            <div class="form-group">
                                <label class="sr-only">库房编号</label>
                                <input type="text" name="room_number" placeholder="库房编号" class="form-control" value="">
                            </div>
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.storageroommanage.roomstruct')}}'">重置</button>
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
                                <th>库房库位名称</th>
                                <th>库房库位编号</th>
                                <th>是否库位</th>
                                <th>库房类型</th>
                                <th>存储方式</th>
                                <th>库房大小</th>
                                <th>是否生效</th>
                                <th>位置</th>
                                <th>负责人</th>
                                <th>操作</th>
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    <td>{{$v['room_name']}}</td>
                                    <td>{{$v['room_number']}}</td>
                                    <td>{{$v['ifstorage']=='1'?'是':'否'}}</td>
                                    <td>{{$v['room_type']}}</td>
                                    <td>{{$v['save_type']}}</td>
                                    <td>{{$v['room_size']}}</td>
                                    <td>{{$v['status']=='1'?'是':'否'}}</td>
                                    <td>{{$v['position']}}</td>
                                    <td>{{$v['leader']}}</td>
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


