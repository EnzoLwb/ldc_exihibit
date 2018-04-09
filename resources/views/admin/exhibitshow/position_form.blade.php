@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.exhibitshow.position')}}">展位管理</a></li>
                        <li @if(!isset($data))class="active"@endif><a href="{{route('admin.exhibitshow.position.add')}}">新增</a></li>
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
                        <form action="{{route('admin.exhibitshow.position.save')}}" method="post" class="form-horizontal ajaxForm">
                            <input type="hidden" value="{{csrf_token()}}" name="_token">
                            <input type="hidden" value="{{$info['show_position_id'] or 0}}" name="show_position_id">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">展位名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="name" value="{{$info['name'] or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">展位编码</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="num" value="{{$info['num'] or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">展陈方式</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="show_way" value="{{$info['show_way'] or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">是否末级</label>
                                <div class="col-sm-4">
                                    <select name="is_last_level" class="form-control">
                                        @foreach(\App\Dao\ConstDao::$show_position_last_desc as $k=>$v)
                                            <option value="{{$k}}" @if(isset($info['is_last_level']) && $k == $info['is_last_level'])
                                            selected
                                                    @endif >{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">是否生效</label>
                                <div class="col-sm-4">
                                    <select name="is_valid" class="form-control">
                                        @foreach(\App\Dao\ConstDao::$show_position_valid_desc as $k=>$v)
                                            <option value="{{$k}}" @if(isset($info['is_valid']) && $k == $info['is_valid'])
                                            selected @endif >{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">位置</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="position" value="{{$info['position'] or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">负责人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="responser" value="{{$info['responser'] or ''}}"/>
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
