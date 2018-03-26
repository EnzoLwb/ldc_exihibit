@extends('layouts.public')

@section('head')
    <link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">
@endsection

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal ajaxForm">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">系统名称</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="system_name" value="{{$setting['system_name'] or ''}}" style=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">系统版本</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="system_version" value="{{$setting['system_version'] or ''}}" style=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Logo</label>
                                <div class="col-sm-10" id="logo_box">
                                    <div id="logo_picker">选择图片</div>
                                    @if(isset($setting['logo']) && $setting['logo'] != '')
                                        <div class="img-div">
                                            <img src="{{get_file_url($setting['logo'])}}"/>
                                            <span class="cancel">×</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="hidden" name="logo" id="logo" value="{{$setting['logo'] or ''}}"/>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">系统简介</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="system_desc">{{$setting['system_desc'] or ''}}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">验证码</label>
                                <div class="col-sm-6 set-lh">
                                    <input class="mt0" type="checkbox" name="captchaadminlogin" value="1" @if(isset($setting['captchaadminlogin']))checked="checked"@endif />
                                    后台登录
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="text-center">
                                    <button class="btn btn-primary" type="submit">保存</button>
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
                type_key: 'FT_COMMON',
                pick: 'logo_picker',
                boxid: 'logo_box',
                file_path: 'logo'
            });
            $('#logo_box').find('.img-div>span').click(function () {
                sUploadDel($(this), 'logo')
            });
        });
    </script>
@endsection