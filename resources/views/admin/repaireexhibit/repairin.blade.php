@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.repaireexhibit.repairin')}}">内修文物管理</a></li>
                        <li><a href="{{route('admin.repaireexhibit.repairin.add')}}">新增内修文物</a></li>
                        <li><a href="{{route('admin.repaireexhibit.repairout')}}">外修文物管理</a></li>
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
                                <label class="sr-only">档案号</label>
                                <input type="text" name="repair_order_name" placeholder="档案号" class="form-control" value="">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.repaireexhibit.repairin')}}'">重置</button>
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
                                <th>档案号</th>
                                <th>藏品名称</th>
                                <th>提取日期</th>
                                <th>归还时间</th>
                                <th>主持人</th>
                                <th>修复人</th>
                                <th>文物现状</th>
                                <th>操作</th>
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    <td>{{$v['repair_order_name']}}</td>
                                    <td>{{$v['name']}}</td>
                                    <td>{{$v['pickup_date']}}</td>
                                    <td>{{$v['return_date']}}</td>
                                    <td>{{$v['host']}}</td>
                                    <td>{{$v['restorer']}}</td>
                                    <td>{{$v['exhibit_status']}}</td>
                                    <td>
                                        <a href="{{route('admin.repaireexhibit.repairin.detail',['inside_repair_id'=>$v['inside_repair_id']])}}">查看详情</a>
                                        <a href="{{route('admin.repaireexhibit.repairin.delete',['inside_repair_id'=>$v['inside_repair_id']])}}"
                                           onclick="if (confirm('确定要删除此记录吗？')==false) return false">删除</a>
                                        <a href="{{route('admin.repaireexhibit.repairin.edit',['inside_repair_id'=>$v['inside_repair_id']])}}">修改</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <div>共 {{ $data->total() }} 条记录</div>
                                <div>{!! $data->links() !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

