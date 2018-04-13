@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.storageroommanage.roomenv')}}">库房环境查询</a></li>
                        <li class="active"><a href="{{route('admin.storageroommanage.roomenv.add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="{{route('admin.storageroommanage.roomenv.save')}}" method="post" class="form-horizontal ajaxForm">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="book_id" value="{{$data['book_id']??''}}">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房编号</label>
                                <div class="col-sm-4">
                                    <select name="room_number" class="form-control">
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
                                <label class="col-sm-2 control-label">库房温度</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="temp" value="{{$data['temp']??old('temp')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房湿度</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="damp" value="{{$data['damp']??old('damp')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">空气净化程度</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="air" value="{{$data['air']??old('air')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房光照率</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="light" value="{{$data['light']??old('light')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">登记人</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="booker" value="{{$data['booker']??old('booker')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">登记日期</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="book_time" name="book_time" value="{{$data['book_time']??old('book_time')}}"/>
                                </div>
                                @if ($errors->has('book_time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('book_time') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">备注</label>
                                <div class="col-sm-4">
                                    <textarea name="remark" class="form-control">{{$data['remark']??old('remark')}}</textarea>
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
        var book_time = laydate.render({
            elem: '#book_time',
            type: 'datetime',
            min: '1999-1-1 00:00:00',
            max: '2099-6-16 23:59:59',
        });

    </script>
@endsection