@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">修改</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">删除</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">提交</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">图文模式</a></li>
                        <li ><a href="{{route('admin.exhibitmanage.outstorageroom.add_exhibitout')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitmanage.instorageroom')}}">
                            <div class="form-group">
                                <input type="text" name="title" placeholder="名称" class="form-control" value="{{request('title')}}">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitmanage.instorageroom')}}'">重置</button>
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
                                <th>提供部门</th>
                                <th>出库目的</th>
                                <th>出库日期</th>
                                <th>库房点叫人</th>
                                <th>提取经手人</th>
                                <th>日期</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="radio"></td>
                                    <td>{{$exhibit['depart_name']}}</td>
                                    <td>{{$exhibit['destion']}}</td>
                                    <td>{{$exhibit['out_date']}}</td>
                                    <td>{{$exhibit['action_name']}} </td>
                                    <td>{{$exhibit['taker_name']}} </td>
                                    <td>{{date("Y-m-d", time())}} </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


