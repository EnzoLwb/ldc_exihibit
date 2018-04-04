@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.storageroommanage.roomlist')}}">盘点任务</a></li>
                        <li @if(!isset($data))class="active"@endif><a href="{{route('admin.storageroommanage.roomlist.add')}}">盘点申请</a></li>
                        @if(isset($data))
                            <li class="active"><a href="#">编辑</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="{{route('admin.storageroommanage.roomlist.save')}}" method="post" class="form-horizontal ajaxForm">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="check_id" value="{{$data['check_id']??''}}">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房编号</label>
                                <div class="col-sm-4">
                                    <select name="room_number" >
                                        @foreach($storage as $v)
                                            <option value="{{$v}}" selected={{@$data['room_number']==$v||old('room_number')==$v?'selected':''}}>{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('room_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('room_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">计划盘点人员</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="plan_member" value="{{$data['plan_member']??old('plan_member')}}"/>
                                </div>
                                @if ($errors->has('plan_member'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('plan_member') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">计划盘点日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="plan_date" name="plan_date" value="{{$data['plan_date']??old('plan_date')}}"/>
                                </div>
                                @if ($errors->has('plan_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('plan_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">盘点文物数量</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="goods_count" value="{{$data['goods_count']??old('goods_count')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">完整文物数量</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="completed_count" value="{{$data['completed_count']??old('completed_count')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">残缺文物数量</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="imcompleted_count" value="{{$data['imcompleted_count']??old('imcompleted_count')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">盘点申请备注</label>
                                <div class="col-sm-4">
                                    <textarea name="apply_remark" class="form-control">{{$data['apply_remark']??old('apply_remark')}}</textarea>
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
        //登记时间
        var plan_date = laydate.render({
            elem: '#plan_date',
            type: 'datetime',
            min: '1999-1-1 00:00:00',
            max: '2099-6-16 23:59:59',
        });

    </script>
@endsection