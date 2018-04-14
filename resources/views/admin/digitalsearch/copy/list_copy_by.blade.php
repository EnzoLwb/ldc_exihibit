@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.digitalsearch.copy')}}">复制品统计</a></li>
                        <li class="active"><a href="{{route('admin.digitalsearch.copy.copy_by')}}">仿制品统计</a></li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.digitalsearch.copy.copy_by')}}">
                            <div class="form-group">
                                <label>类别</label>
                                <input name="range_type" value="{{request('range_type')}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>名称</label>
                                <input name="name" value="{{request('name')}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>时间</label>
                                <input name="created_at" value="{{request('created_at')}}" class="form-control">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
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
                                <th>总登记号</th>
                                <th>原编号</th>
                                <th>名称</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td>{{$exhibit['exhibit_sum_register_num']}}</td>
                                    <td>{{$exhibit['ori_num']}}</td>
                                    <td>{{$exhibit['name']}}</td>
                                    <td><a target="_blank" href="{{route('admin.digitalsearch.view_subsidiary')."?subsidiary_id=".$exhibit['subsidiary_id']}}">查看</td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <div>共 {{ $exhibit_list->total() }} 条记录</div>
                                {!! $exhibit_list->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection