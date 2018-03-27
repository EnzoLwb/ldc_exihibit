@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitidentify.manage')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitidentify.manage')}}">修改</a></li>
                        <li><a href="{{route('admin.exhibitidentify.manage')}}">删除</a></li>
                        <li><a href="{{route('admin.exhibitidentify.manage')}}">提交</a></li>
                        <li><a href="{{route('admin.exhibitidentify.manage')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitidentify.manage')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitidentify.manage')}}">图文模式</a></li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitidentify.apply')}}">
                            <div class="form-group">
                                <input type="text" name="title" placeholder="登记日期" class="form-control" value="{{request('title')}}">
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
                                <th>登记日期</th>
                                <th>鉴定申请单位名称</th>
                                <th>拟检定日期</th>
                                <th>拟鉴定专家</th>
                                <th>拟鉴定单位</th>
                                <th>状态</th>
                                <th>登记人</th>

                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td>{{$exhibit->exhibit_num}}</td>
                                    <td>{{$exhibit->title}}</td>
                                    <td><img width="50px" heighy='60px'src="{{$exhibit->squar_list_img}}"/></td>
                                    <td>
                                        <a href="{{url('/admin/data/exhibit_add?exhibit_id=' . $exhibit->exhibit_id)}}">编辑</a>
                                        | <a class="ajaxBtn" href="javascript:void(0);" uri="{{url('/admin/data/exhibit_del?exhibit_id=' . $exhibit->exhibit_id)}}" msg="是否删除该文物？">删除</a>

                                    </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection