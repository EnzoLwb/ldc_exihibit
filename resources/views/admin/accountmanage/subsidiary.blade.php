@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.accountmanage.subsidiary')}}">查询</a></li>

                        <li><a href="{{route('admin.accountmanage.subsidiary')}}">浏览</a></li>
                        <li><a href="{{route('admin.accountmanage.subsidiary')}}">注销</a></li>
                        <li><a href="{{route('admin.accountmanage.subsidiary')}}">导出</a></li>
                        <li><a href="{{route('admin.accountmanage.subsidiary')}}">打印</a></li>
                        <li><a href="{{route('admin.accountmanage.subsidiary')}}">图文模式</a></li>
                        <li><a href="{{route('admin.accountmanage.add_subsidiary')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{url('admin/data/exhibit')}}">
                            <select class="form-control">
                                <option>未定级文物登记账</option>
                                <option>复制品登记账</option>
                                <option>仿制品登记账</option>
                                <option>资料登记账</option>
                                <option>借入文物登记账</option>
                                <option>代管文物登记账</option>
                                <option>外借文物登记账</option>
                            </select>
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
                                <th>图片</th>
                                <th>收藏单位</th>
                                <th>总登记号</th>
                                <th>原编号</th>
                                <th>分类号</th>
                                <th>入馆登记号</th>
                                <th>名称</th>
                                <th>原名</th>
                                <th>年代类型</th>
                                <th>具体年代</th>
                                <th>历史阶段</th>
                                <th>质地</th>
                                <th>质地类型1</th>
                                <th>质地类型2</th>
                                <th>普查质地</th>
                                <th>具体质地</th>
                                <th>类别范围</th>
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


