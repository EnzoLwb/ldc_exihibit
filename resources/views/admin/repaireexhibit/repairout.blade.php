@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.repaireexhibit.repairin')}}">内修文物管理</a></li>
                        <li><a href="{{route('admin.repaireexhibit.repairin.add')}}">新增内修文物</a></li>
                        <li class="active"><a href="{{route('admin.repaireexhibit.repairout')}}">外修文物管理</a></li>
                        <li><a href="{{route('admin.repaireexhibit.repairout.add')}}">新增外修文物</a></li>
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
                                <label class="sr-only">藏品名称</label>
                                <input type="text" name="" placeholder="藏品名称" class="form-control" value="">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.repaireexhibit.repairout')}}'">重置</button>
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
                                <th>藏品名称</th>
                                <th>残损情况</th>
                                <th>修复要求</th>
                                <th>时间</th>
                                <th>修复数量</th>
                                <th>估价</th>
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

