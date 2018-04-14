@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.digitalsearch.repaire')}}">内修文物查询</a></li>
                        <li><a href="{{route('admin.digitalsearch.repaireout')}}">外修文物查询</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.digitalsearch.repaire')}}">
                            <div class="ibox float-e-margins">
                                <div class="form-group">
                                    <label>提取日期</label>
                                    <input placeholder="提取日期" class="form-control layer-date laydate-icon"
                                           id="pickup_date" type="text" name="pickup_date" value=""
                                           style="width: 140px;">
                                    <label>归还日期</label>
                                    <input placeholder="归还日期" class="form-control layer-date laydate-icon" id="return_date"
                                           type="text" name="return_date" value=""        style="width: 140px;">
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
                                        <label>档案号</label>
                                        <input name="repair_order_name" value="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>藏品分类号</label>
                                        <input name="type_num" value="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>藏品年代</label>
                                        <input name="age" value="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>主持人</label>
                                        <input name="host" value="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>修复人</label>
                                        <input name="restorer" value="" class="form-control">
                                    </div>
                            &nbsp;   </div>
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
                                <th>档案号</th>
                                <th>藏品名称</th>
                                <th>藏品分类号</th>
                                <th>藏品年代</th>
                                <th>提取日期</th>
                                <th>归还时间</th>
                                <th>主持人</th>
                                <th>修复人</th>
                                <th>文物现状</th>
                                <th>申请状态</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $v)
                                <tr class="gradeA">
                                    <td>{{$v['repair_order_name']}}</td>
                                    <td>{{$v['name']}}</td>
                                    <td>{{$v['type_num']}}</td>
                                    <td>{{$v['age']}}</td>
                                    <td>{{$v['pickup_date']}}</td>
                                    <td>{{$v['return_date']}}</td>
                                    <td>{{$v['host']}}</td>
                                    <td>{{$v['restorer']}}</td>
                                    <td>{{$v['exhibit_status']}}</td>
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
            elem: "#pickup_date",
            choose: function (datas) {
            }
        });
        laydate(start);

        var end = $.extend({}, laydateOptions, {
            elem: "#return_date",
            choose: function (datas) {
            }
        });
        laydate(end);
    </script>
@endsection
