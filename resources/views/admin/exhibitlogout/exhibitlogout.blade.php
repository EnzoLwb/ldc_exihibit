@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.exhibitlogout')}}">藏品注销</a></li>
                        <li><a href="{{route('admin.exhibitlogout.add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get">
                            <div class="form-group">
                                <label class="sr-only">注销凭证号</label>
                                <input type="text" name="" placeholder="注销凭证号" class="form-control" value="">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitlogout')}}'">重置</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover">
                            <tr class="gradeA">
                                <th>注销凭证号</th>
                                <th>注销凭证名称</th>
                                <th>注销日期</th>
                                <th>注销批准文号</th>
                                <th>注销原因</th>
                                <th>详情描述</th>
                                <th>登记人</th>
                                <th>登记日期</th>
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    <td></td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                {{--<div>共 {{ $data->total() }} 条记录</div>--}}
                                {{--{!! $data->links() !!}--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

