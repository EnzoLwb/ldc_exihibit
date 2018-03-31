@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.repaireexhibit.repairin')}}">内修文物管理</a></li>
                        <li><a href="{{route('admin.repaireexhibit.repairin.add')}}">新增内修文物</a></li>
                        <li><a href="{{route('admin.repaireexhibit.repairout')}}">外修文物管理</a></li>
                        <li><a href="{{route('admin.repaireexhibit.repairout.add')}}">新增外修文物</a></li>
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
                                <label class="sr-only">档案号</label>
                                <input type="text" name="" placeholder="档案号" class="form-control" value="">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.repaireexhibit.repairin')}}'">重置</button>
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
                                <th>档案号</th>
                                <th>藏品名称</th>
                                <th>提取日期</th>
                                <th>修复时间</th>
                                <th>归还时间</th>
                                <th>主持人</th>
                                <th>修复人</th>
                                <th>文物现状</th>
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    <td>{{$v['file_num']}}</td>
                                    <td>{{$v['exhibit_name']}}</td>
                                    <td>{{$v['take_date']}}</td>
                                    <td>{{$v['repair_date']}}</td>
                                    <td>{{$v['back_date']}}</td>
                                    <td>{{$v['responser']}}</td>
                                    <td>{{$v['repairer']}}</td>
                                    <td>{{$v['exhibit_status']}}</td>
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

