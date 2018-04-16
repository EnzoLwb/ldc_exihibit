@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.storageroommanage.frame')}}">查询</a></li>
                        <li class="active"><a href="{{route('admin.storageroommanage.frame.add')}}">编辑</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="{{route('admin.storageroommanage.frame.save')}}" method="post" class="form-horizontal ajaxForm">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="frame_id" value="{{$info['frame_id']}}">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房名称</label>
                                <div class="col-sm-4">
                                    <select name="room_number" class="form-control">
                                        @foreach($storage as $v)
                                            <option value="{{$v->room_number}}" @if($info['room_number'] == $v->room_number) selected @endif>{{$v->room_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">排架编号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="frame_number" value="{{$info['frame_number'] or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">排架名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="frame_name" name="frame_name" value="{{$info['frame_name'] or ''}}"/>
                                </div>
                            </div>
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