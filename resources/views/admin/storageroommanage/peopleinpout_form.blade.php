@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.storageroommanage.peopleinoutmanage')}}">查询</a></li>
                        <li><a href="{{route('admin.storageroommanage.peopleinoutmanage')}}">修改</a></li>
                        <li><a href="{{route('admin.storageroommanage.peopleinoutmanage')}}">删除</a></li>
                        <li><a href="{{route('admin.storageroommanage.peopleinoutmanage')}}">导出</a></li>
                        <li><a href="{{route('admin.storageroommanage.peopleinoutmanage')}}">打印</a></li>
                        <li><a href="{{route('admin.storageroommanage.peopleinoutmanage')}}">图文模式</a></li>
                        <li ><a href="{{route('admin.storageroommanage.peopleinoutmanage.add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="{{route('admin.storageroommanage.peopleinoutmanage.save')}}" method="post" class="form-horizontal">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="pio_id" value="{{$data['pio_id']??''}}">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房编号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="storeroom_id"
                                           value="{{$data['storeroom_id']??old('storeroom_id')}}"/>
                                </div>
                                @if ($errors->has('storeroom_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('storeroom_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">入库时间</label>
                                <div class="col-sm-2">
                                    <input placeholder="入库时间" class="form-control layer-date laydate-icon" id="comein_time" type="text" name="comein_time"
                                           value="{{$data['comein_time']??old('comein_time')}}">
                                </div>
                                @if ($errors->has('comein_time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comein_time') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">计划出库时间</label>
                                <div class="col-sm-2">
                                    <input placeholder="计划出库时间" class="form-control layer-date laydate-icon" id="plan_goout_time" type="text" name="plan_goout_time"
                                           value="{{$data['plan_goout_time']??old('plan_goout_time')}}">
                                </div>
                                @if ($errors->has('plan_goout_time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('plan_goout_time') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">实际出库时间</label>
                                <div class="col-sm-2">
                                    <input placeholder="实际出库时间" class="form-control layer-date laydate-icon" id="real_goout_time" type="text" name="real_goout_time"
                                           value="{{$data['real_goout_time']??old('real_goout_time')}}">
                                </div>
                                @if ($errors->has('real_goout_time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('real_goout_time') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">入库人员</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="comein_member"
                                           value="{{$data['comein_member']??old('comein_member')}}"/>
                                </div>
                                @if ($errors->has('comein_member'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comein_member') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">陪同人员</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="with_member"
                                           value="{{$data['plan_goout_time']??old('plan_goout_time')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">进库人单位</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="comein_department"
                                           value="{{$data['comein_department']??old('comein_department')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">出入事由</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="reason"
                                           value="{{$data['reason']??old('reason')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">备注</label>
                                <div class="col-sm-4">
                                    <textarea  class="form-control" name="remark">{{$data['remark']??old('remark')}}</textarea>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit">保存</button>
                                    <button class="btn btn-white" type="button" id="backBtn">返回</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{cdn('js/plugins/laydate_new/laydate.js')}}"></script>
    <script type="text/javascript">
        //入库时间设置
        var comein_time = laydate.render({
            elem: '#comein_time',
            type: 'datetime',
            min: '1999-1-1 00:00:00',
            max: '2099-6-16 23:59:59',
            done: function(value, date){
                //限制出库的时间不能低于入库时间（只是显示）后台还要再验证
                plan_goout_time.config.min = {
                    date:date.date,
                    hours:date.hours,
                    minutes:date.minutes+1,
                    month:date.month-1,
                    seconds:date.seconds,
                    year:date.year,
                };
                real_goout_time.config.min = {
                    date:date.date,
                    hours:date.hours,
                    minutes:date.minutes+1,
                    month:date.month-1,
                    seconds:date.seconds,
                    year:date.year,
                };
            }
        });
        //预计出库时间设置
        var plan_goout_time = laydate.render({
            elem: '#plan_goout_time',
            type: 'datetime',
            min: '1900-1-1 00:00:00',
            max: '2099-6-16 23:59:59',
            done: function(value, date){
                comein_time.config.max = {
                    year: date.year,
                    month: date.month - 1,
                    date: date.date,
                    hours: date.hours,
                    minutes: date.minutes,
                    seconds: date.seconds
                }; //结束日选好后，重置开始日的最大日期
            }
        });
        //实际出库时间设置
        var real_goout_time = laydate.render({
            elem: '#real_goout_time',
            type: 'datetime',
            min: '1900-1-1 00:00:00',
            max: '2099-6-16 23:59:59',
            done: function(value, date){
                comein_time.config.max = {
                    year: date.year,
                    month: date.month - 1,
                    date: date.date,
                    hours: date.hours,
                    minutes: date.minutes,
                    seconds: date.seconds
                }; //结束日选好后，重置开始日的最大日期
            }
        });

    </script>
@endsection