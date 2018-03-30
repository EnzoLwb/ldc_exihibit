@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitmanage.instorageroom')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitmanage.instorageroom')}}">修改</a></li>
                        <li><a href="{{route('admin.exhibitmanage.instorageroom')}}">删除</a></li>
                        <li><a href="{{route('admin.exhibitmanage.instorageroom')}}">提交</a></li>
                        <li><a href="{{route('admin.exhibitmanage.instorageroom')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.instorageroom')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitmanage.instorageroom')}}">图文模式</a></li>
                        <li ><a href="{{route('admin.exhibitmanage.add_instorageroom')}}">新增</a></li>
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
                                <th>总登记号</th>
                                <th>入馆凭证号</th>
                                <th>名称</th>
                                <th>数量</th>
                                <th>年代</th>
                                <th>级别</th>
                                <th>尺寸</th>
                                <th>重量</th>
                                <th>完残情况</th>
                                <th>分库号</th>
                                <th>入馆日期</th>
                                <th>来源</th>
                                <th>收据号</th>
                                <th>备注</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="radio"></td>
                                    <td>{{$exhibit['sum_register_num']}}</td>
                                    <td>{{$exhibit['enter_museum_num']}}</td>
                                    <td>{{$exhibit['name']}}</td>
                                    <td>{{$exhibit['count']}} </td>
                                    <td>{{$exhibit['age']}} </td>
                                    <td>{{$exhibit['class']}} </td>
                                    <td>{{$exhibit['size']}} </td>
                                    <td>{{$exhibit['weight']}} </td>
                                    <td>{{$exhibit['current_info']}} </td>
                                    <td>{{$exhibit['room_num']}} </td>
                                    <td>{{$exhibit['enter_museum_date']}} </td>
                                    <td>{{$exhibit['src']}} </td>
                                    <td>{{$exhibit['recipe_num']}} </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


