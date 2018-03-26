@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.setting.adminusers')}}">管理员列表</a></li>
                        <li @if(!isset($user))class="active"@endif><a href="{{route('admin.setting.adminusers.add')}}">添加管理员</a></li>
                        @if(isset($user))
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
                        <form action="{{route('admin.setting.adminusers.save')}}" method="post" class="form-horizontal ajaxForm">
                            <input type="hidden" name="uid" value="{{$user->uid or 0}}"/>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">用户名</label>
                                <div class="col-sm-4">
                                    @if(isset($user))
                                        <p class="form-control-static">{{$user->username}}</p>
                                    @else
                                        <input type="text" class="form-control" name="username" value="" required/>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" name="password" @if(isset($user))placeholder="不修改密码请留空" @else required @endif/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">姓名</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="nickname" value="{{$user->nickname or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">邮箱</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="email" value="{{$user->email or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">手机</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="phone" value="{{$user->phone or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">角色</label>
                                <div class="col-sm-4">
                                    <select class="form-control m-b" name="groupid" required>
                                        <option value="">请选择角色</option>
                                        @foreach($userGroups as $ugroup)
                                            <option value="{{$ugroup->groupid}}"
                                                    @if(isset($user->groupid) && $user->groupid == $ugroup->groupid) selected="selected"@endif>{{$ugroup->groupname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit">保存</button>
                                    <button class="btn btn-white" type="button" onclick="window.history.back()">返回</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
