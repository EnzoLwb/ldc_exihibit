@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitmanage.disinfection')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitmanage.disinfection')}}">修改</a></li>
                        <li><a href="{{route('admin.exhibitmanage.disinfection')}}">删除</a></li>
                        <li><a href="{{route('admin.exhibitmanage.disinfection')}}">提交</a></li>
                        <li><a href="{{route('admin.exhibitmanage.disinfection')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.disinfection')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitmanage.disinfection')}}">图文模式</a></li>
                        <li ><a href="{{route('admin.exhibitmanage.add_disinfection')}}">新增</a></li>
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
                                <th>藏品名称</th>
                                <th>总登记号</th>
                                <th>清洁方式</th>
                                <th>消毒方式</th>
                                <th>申请部门</th>
                                <th>清洁日期</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="radio"></td>
                                    <td>{{$exhibit['name']}}</td>
                                    <td>{{$exhibit['sum_register_num']}}</td>
                                    <td>{{$exhibit['clean_way']}}</td>
                                    <td>{{$exhibit['disinfection_way']}} </td>
                                    <td>{{$exhibit['apply_depart']}} </td>
                                    <td>{{$exhibit['date']}} </td>

                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


