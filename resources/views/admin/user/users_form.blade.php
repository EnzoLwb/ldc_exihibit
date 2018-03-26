@extends('layouts.public')

@section('head')
    <link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">
@endsection

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.user.users')}}">用户列表</a></li>
                        <li @if(!isset($user))class="active"@endif><a href="{{route('admin.user.users.add')}}">添加用户</a></li>
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
                        <form action="{{route('admin.user.users.save')}}" method="post" class="form-horizontal ajaxForm">
                            <input type="hidden" name="uid" value="{{$user->uid or 0}}"/>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">用户名</label>
                                <div class="col-sm-3">
                                    @if(!isset($user))
                                        <input type="text" class="form-control" name="username" autocomplete="off"/>
                                    @else
                                        <p class="form-control-static">{{$user->username}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-3">
                                    <input type="password" class="form-control" name="password" @if(isset($user)) placeholder="不修改密码请留空" @endif autocomplete="off"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">昵称</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="nickname" value="{{$user->nickname or ''}}"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">邮箱</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="email" value="{{$user->email or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">手机</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="phone" value="{{$user->phone or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">头像</label>
                                <div class="col-sm-10" id="avatar_box">
                                    <div id="avatar_picker">选择图片</div>
                                    @if(isset($user) && $user->avatar != '')
                                        <div class="img-div">
                                            <img src="{{get_file_url($user->avatar)}}"/>
                                            <span class="cancel">×</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="hidden" id="avatar" name="avatar" value="{{$user->avatar or ''}}"/>
                                <input type="hidden" id="avatar_file_id" name="avatar_file_id" value=""/>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    @if (isset($user))
                                        <button class="btn btn-primary" type="submit">保存</button>
                                        <button class="btn btn-white" type="button" id="backBtn">返回</button>
                                    @else
                                        <button class="btn btn-primary" type="submit">添加</button>
                                        <button class="btn btn-white" type="reset" id="reset">重置</button>
                                    @endif
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
    <script src="{{cdn('js/plugins/webuploader/webuploader.nolog.min.js')}}"></script>
    <script src="{{cdn('js/plugins/webuploader/webuploader_public.js')}}"></script>
    <script type="text/javascript">
        jQuery(function ($) {
            singleUpload({
                _token: '{{csrf_token()}}',
                type_key: 'FT_AVATAR',
                item_id: '{{$user->uid or 0}}',
                pick: 'avatar_picker',
                boxid: 'avatar_box',
                file_path: 'avatar',
                file_id: 'avatar_file_id'
            });
            $('#avatar_box').find('.img-div>span').click(function () {
                sUploadDel($(this), 'avatar');
            });
        });
    </script>
@endsection