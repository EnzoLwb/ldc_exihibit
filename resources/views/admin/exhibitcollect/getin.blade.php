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
                                <th>入馆凭证号</th>
                                <th>入馆凭证名称</th>
                                <th>入馆日期</th>
                                <th>收据号</th>
                                <th>备注</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="radio"></td>
                                    <td>{{$exhibit['num']}}
                                    </td>
                                    <td>{{$exhibit['name']}}
                                    </td>
                                    <td>{{$exhibit['date']}}
                                    </td>
                                    <td>{{$exhibit['recipe_num']}}
                                    </td>
                                    <td>{{$exhibit['mark']}}
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


