@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.accountmanage.sumaccount')}}">查询</a></li>

                        <li><a href="{{route('admin.accountmanage.sumaccount')}}">总账复核</a></li>

                        <li><a href="{{route('admin.accountmanage.sumaccount')}}">导出</a></li>
                        <li><a href="{{route('admin.accountmanage.sumaccount')}}">打印</a></li>
                        <li><a href="{{route('admin.accountmanage.sumaccount')}}">图文模式</a></li>
                        <li><a href="{{route('admin.accountmanage.add_sumaccount')}}">修改</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{url('admin/data/exhibit')}}">
                            <div class="form-group">
                                <input type="text" name="title" placeholder="申请单号" class="form-control" value="{{request('title')}}">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitcollect.apply')}}'">重置</button>
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
                                <th>原编号</th>
                                <th>曾用号</th>
                                <th>入馆凭证号</th>
                                <th>现用名</th>
                                <th>曾用名</th>
                                <th>年代类型</th>
                                <th>具体年代</th>
                                <th>历史阶段</th>
                                <th>质地类型1</th>
                                <th>...</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="radio"></td>
                                    <td>{{$exhibit['apply_num']}}</td>
                                    <td>{{$exhibit['apply_depart_name']}}</td>
                                    <td>{{$exhibit['apply_buy_object']}}</td>
                                    <td>{{$exhibit['project_name']}} </td>
                                    <td>{{$exhibit['depart_name']}} </td>
                                    <td>{{$exhibit['need_money']}} </td>
                                    <td>{{$exhibit['need_count']}} </td>
                                    <td>{{$exhibit['applyer']}} </td>
                                    <td>{{$exhibit['project_desc']}} </td>
                                    <td>{{$exhibit['apply_reason']}} </td>
                                    <td>{{$exhibit['...']}} </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


