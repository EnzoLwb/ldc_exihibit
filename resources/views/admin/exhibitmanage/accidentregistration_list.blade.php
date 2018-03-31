@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitmanage.accidentregistration')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitmanage.accidentregistration')}}">修改</a></li>
                        <li><a href="{{route('admin.exhibitmanage.accidentregistration')}}">删除</a></li>
                        <li><a href="{{route('admin.exhibitmanage.accidentregistration')}}">提交</a></li>
                        <li><a href="{{route('admin.exhibitmanage.accidentregistration')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.accidentregistration')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitmanage.accidentregistration')}}">图文模式</a></li>
                        <li ><a href="{{route('admin.exhibitmanage.add_accidentregistration')}}">新增</a></li>
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
                                <input type="text" name="title" placeholder="文物名称" class="form-control" value="{{request('title')}}">
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
                                <th>文物名称</th>
                                <th>总登记号</th>
                                <th>事故时间</th>
                                <th>事故人</th>
                                <th>事故描述</th>
                                <th>处理依据</th>
                                <th>处理意见</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="radio"></td>
                                    <td>{{$exhibit['exhibit_name']}}</td>
                                    <td>{{$exhibit['sum_register_num']}}</td>
                                    <td>{{$exhibit['accident_date']}}</td>
                                    <td>{{$exhibit['accident_maker']}} </td>
                                    <td>{{$exhibit['accident_desc']}} </td>
                                    <td>{{$exhibit['handle_dependy']}} </td>
                                    <td>{{$exhibit['handle_result']}} </td>

                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


