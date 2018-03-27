@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitcollect.getin')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">修改</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">删除</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">提交</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">送鉴定</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">图文模式</a></li>
                        <li ><a href="{{route('admin.exhibitcollect.getin_add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.exhibitcollect.getin')}}">
                            <select class="form-control">
                                <option value="apply_in">征集入馆</option>
                                <option value="direct_in">直接入馆</option>
                            </select>
                            <button type="submit" class="btn btn-primary">查询</button>
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


