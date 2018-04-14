@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.digitalsearch.repaire')}}">内修文物查询</a></li>
                        <li class="active"><a href="{{route('admin.digitalsearch.repaireout')}}">外修文物查询</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.digitalsearch.repaireout')}}">
                            <div class="ibox float-e-margins">
                                <div class="form-group">
                                    <label>时间</label>
                                    <input placeholder="时间" class="form-control layer-date laydate-icon"
                                           id="date" type="text" name="date" value=""
                                           style="width: 140px;">
                                </div>
                            </div>
                            <div class="ibox float-e-margins">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>藏品名称</label>
                                            <input name="name" value="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>藏品分类号</label>
                                            <input name="type_num" value="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>藏品年代</label>
                                            <input name="age" value="" class="form-control">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="reset" class="btn btn-primary">重置</button>
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
                                <th>藏品名称</th>
                                <th>藏品分类号</th>
                                <th>藏品年代</th>
                                <th>时间</th>
                                <th>申请状态</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $v)
                                <tr class="gradeA">
                                    <td>{{$v['name']}}</td>
                                    <td>{{$v['type_num']}}</td>
                                    <td>{{$v['age']}}</td>
                                    <td>{{$v['date']}}</td>
                                    <td>{{$v->applyStatus($v['apply_status'])}}</td>
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
    <script type="text/javascript" src="{{cdn('js/public.js')}}"></script>
    <script type="text/javascript" src="{{cdn('js/plugins/laydate/laydate.js')}}"></script>

    <script>
        var start = $.extend({}, laydateOptions, {
            elem: "#date",
            choose: function (datas) {
            }
        });
        laydate(start);

        var end = $.extend({}, laydateOptions, {
            elem: "#date",
            choose: function (datas) {
            }
        });
        laydate(end);
    </script>
@endsection
