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
                        <form role="form" class="form-inline" method="get">
                            <div class="form-group">
                                <label class="sr-only">库房库位名称</label>
                                <input type="text" name="username" placeholder="库房库位名称" class="form-control" value="">
                            </div>
                            &nbsp;&nbsp;
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
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    <td>{{$v['name']}}</td>
                                    <td>{{$v['num']}}</td>
                                    <td>{{$v['is_kuwei']}}</td>
                                    <td>{{$v['kufang_type']}}</td>
                                    <td>{{$v['storage_way']}}</td>
                                    <td>{{$v['kufang_size']}}</td>
                                    <td>{{$v['is_valid']}}</td>
                                    <td>{{$v['position']}}</td>
                                    <td>{{$v['charity']}}</td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                {{--<div>共 {{ $data->total() }} 条记录</div>--}}
                                {{--{!! $data->links() !!}--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


