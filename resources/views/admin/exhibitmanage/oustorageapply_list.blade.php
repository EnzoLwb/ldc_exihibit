@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitmanage.outstorageroom.oustorageapply')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.oustorageapply')}}">修改</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.oustorageapply')}}">删除</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.oustorageapply')}}">提交</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.oustorageapply')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.oustorageapply')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.oustorageapply')}}">图文模式</a></li>
                        <li ><a href="{{route('admin.exhibitmanage.outstorageroom.add_oustorageapply')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitmanage.outstorageroom.oustorageapply')}}">
                            <div class="form-group">
                                <input type="text" name="title" placeholder="经办人" class="form-control" value="{{request('title')}}">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitmanage.outstorageroom.oustorageapply')}}'">重置</button>
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
                                <th>申请部门名称</th>
                                <th>经办人</th>
                                <th>联系人</th>
                                <th>联系方式</th>
                                <th>出库时间</th>
                                <th>藏品清单</th>
                                <th>出库目的</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="radio"></td>
                                    <td>{{$exhibit['apply_departname']}}</td>
                                    <td>{{$exhibit['apply_name']}}</td>
                                    <td>{{$exhibit['connector_name']}}</td>
                                    <td>{{$exhibit['connector_phone']}} </td>
                                    <td>{{$exhibit['out_date']}} </td>
                                    <td>{{$exhibit['exhibit_list']}} </td>
                                    <td>{{$exhibit['destination']}} </td>

                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


