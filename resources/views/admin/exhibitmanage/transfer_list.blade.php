@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitmanage.transfer')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitmanage.transfer')}}">修改</a></li>
                        <li><a href="{{route('admin.exhibitmanage.transfer')}}">删除</a></li>
                        <li><a href="{{route('admin.exhibitmanage.transfer')}}">提交</a></li>
                        <li><a href="{{route('admin.exhibitmanage.transfer')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.transfer')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitmanage.transfer')}}">图文模式</a></li>
                        <li ><a href="{{route('admin.exhibitmanage.add_transfer')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitmanage.disinfection')}}">
                            <div class="form-group">
                                <input type="text" name="title" placeholder="藏品名称" class="form-control" value="{{request('title')}}">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitmanage.disinfection')}}'">重置</button>
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
                                <th>征集申请单号</th>
                                <th>征集申请单位名称</th>
                                <th>征集采购对象</th>
                                <th>申请征集项目名称</th>
                                <th>申请部门</th>
                                <th>所需征集经费</th>
                                <th>申请征集数量</th>
                                <th>申请人</th>
                                <th>具体征集项目介绍</th>
                                <th>征集原因</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="radio"></td>
                                    <td>{{$exhibit['num']}}</td>
                                    <td>{{$exhibit['depart_name']}}</td>
                                    <td>{{$exhibit['depart_object']}}</td>
                                    <td>{{$exhibit['depart_project_name']}} </td>
                                    <td>{{$exhibit['apply_depart']}} </td>
                                    <td>{{$exhibit['apply_money']}} </td>
                                    <td>{{$exhibit['apply_count']}} </td>
                                    <td>{{$exhibit['applyer']}} </td>
                                    <td>{{$exhibit['project_desc']}} </td>
                                    <td>{{$exhibit['project_reason']}} </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


