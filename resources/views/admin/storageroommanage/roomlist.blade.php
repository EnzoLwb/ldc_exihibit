@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.storageroommanage.roomlist.add')}}">盘点申请</a></li>
                        <li @if(empty($finished))class="active"@endif><a href="{{route('admin.storageroommanage.roomlist')}}">盘点任务</a></li>
                        <li @if(isset($finished)&&$finished=='done')class="active"@endif><a href="{{route('admin.storageroommanage.roomlist',['finished'=>'done'])}}">历史盘点任务</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.storageroommanage.roomlist')}}">
                            <div class="form-group">
                                <label class="sr-only">计划盘点人员</label>
                                <input type="text" name="plan_member" placeholder="计划盘点人员" class="form-control" value="">
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
                                <th>库房编号</th>
                                <th>计划盘点人员</th>
                                <th>计划盘点日期</th>
                                <th>盘点文物数量</th>
                                <th>完整文物数量</th>
                                <th>残缺文物数量</th>
                                <th>申请状态</th>
                                <th>盘点状态</th>
                                <th>备注</th>
                                @if(empty($finished))
                                <th>操作</th>
                                @endif
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    <td>{{$v['room_number']}}</td>
                                    <td>{{$v['plan_member']}}</td>
                                    <td>{{$v['plan_date']}}</td>
                                    <td>{{$v['goods_count']}}</td>
                                    <td>{{$v['completed_count']}}</td>
                                    <td>{{$v['imcompleted_count']}}</td>
                                    <td>{{$v->applyStatus($v['apply_status'])}}</td>
                                    <td>{{$v->checkStatus($v['check_status'])}}</td>
                                    <td width="20%">{{$v['apply_remark']}}</td>
                                    @if(empty($finished))
                                    <td>
                                        <a href="{{route('admin.storageroommanage.roomlist.delete',['check_id'=>$v['check_id']])}}"
                                           onclick="if (confirm('确定要删除此记录吗？')==false) return false">删除</a>
                                        <a href="{{route('admin.storageroommanage.roomlist.edit',['check_id'=>$v['check_id']])}}">开始</a>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <div style="text-align: right">共 {{ $data->total() }} 条记录</div>
                                <div style="text-align: center">{!! $data->links() !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

