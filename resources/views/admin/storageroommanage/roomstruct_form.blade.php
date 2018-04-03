@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.storageroommanage.roomstruct')}}">库房结构管理</a></li>
                        <li @if(!isset($data))class="active"@endif><a href="{{route('admin.storageroommanage.roomstruct.add')}}">新增</a></li>
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
                        <form action="{{route('admin.storageroommanage.roomstruct.save')}}" method="post" class="form-horizontal ajaxForm">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="room_id" value="{{$data['room_id']??''}}">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房库位名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="room_name" value="{{$data['room_name']??old('room_name')}}"/>
                                </div>
                                @if ($errors->has('room_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('room_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房库位编号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="room_number" value="{{$data['room_number']??old('room_number')}}"/>
                                </div>
                                @if ($errors->has('room_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('room_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">是否库位</label>
                                <div class="col-sm-2">
                                    <input type="radio"  name="ifstorage" value="1" />是
                                    <input type="radio"  name="ifstorage" value="0" />否
                                </div>
                                @if ($errors->has('ifstorage'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ifstorage') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房类型</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="room_type" value="{{$data['room_type']??old('room_type')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">存储方式</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="save_type" value="{{$data['save_type']??old('save_type')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房大小</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="room_size" value="{{$data['room_size']??old('room_size')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">是否生效</label>
                                <div class="col-sm-2">
                                    <input type="radio"  name="status" value="1" />是
                                    <input type="radio"  name="status" value="0" />否
                                </div>
                                @if ($errors->has('status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">位置</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="position" value="{{$data['position']??old('position')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">负责人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="leader" value="{{$data['leader']??old('leader')}}"/>
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
