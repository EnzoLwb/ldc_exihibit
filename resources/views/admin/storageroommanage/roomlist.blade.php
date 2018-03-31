@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.storageroommanage.roomlist')}}">盘点任务</a></li>
                        <li><a href="{{route('admin.storageroommanage.roomlist.add')}}">盘点申请</a></li>
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
                                <label class="sr-only">计划盘点人员</label>
                                <input type="text" name="" placeholder="计划盘点人员" class="form-control" value="">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.storageroommanage.roomlist')}}'">重置</button>
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
                                <th>计划盘点人员</th>
                                <th>计划盘点日期</th>
                                <th>盘点文物数量</th>
                                <th>完整文物数量</th>
                                <th>残缺文物数量</th>
                                <th>备注</th>
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    <td>{{$v['charity_people']}}</td>
                                    <td>{{$v['check_date']}}</td>
                                    <td>{{$v['check_exhibit_count']}}</td>
                                    <td>{{$v['whole_exhibit_count']}}</td>
                                    <td>{{$v['half_exhibit_count']}}</td>
                                    <td>{{$v['mark']}}</td>

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

