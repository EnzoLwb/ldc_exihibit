@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitmanage.exhibitbackroom')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitmanage.exhibitbackroom')}}">修改</a></li>
                        <li><a href="{{route('admin.exhibitmanage.exhibitbackroom')}}">删除</a></li>
                        <li><a href="{{route('admin.exhibitmanage.exhibitbackroom')}}">提交</a></li>
                        <li><a href="{{route('admin.exhibitmanage.exhibitbackroom')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.exhibitbackroom')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitmanage.exhibitbackroom')}}">图文模式</a></li>
                        <li ><a href="{{route('admin.exhibitmanage.add_exhibitbackroom')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitmanage.exhibitbackroom')}}">
                            <div class="form-group">
                                <input type="text" name="title" placeholder="文物名称" class="form-control" value="{{request('title')}}">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitmanage.exhibitbackroom')}}'">重置</button>
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
                                <th>文物名称</th>
                                <th>退换人</th>
                                <th>点收人</th>
                                <th>退换日期</th>
                                <th>备注</th>
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


