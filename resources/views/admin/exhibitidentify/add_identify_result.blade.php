@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.exhibitidentify.apply')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitidentify.apply')}}">修改</a></li>
                        <li><a href="{{route('admin.exhibitidentify.apply')}}">删除</a></li>
                        <li><a href="{{route('admin.exhibitidentify.apply')}}">提交</a></li>
                        <li class="active"><a href="{{route('admin.exhibitidentify.add_identify_result')}}">录入鉴定结果</a></li>
                        <li><a href="{{route('admin.exhibitidentify.apply')}}">查看鉴定结果</a></li>
                        <li><a href="{{route('admin.exhibitidentify.apply')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitidentify.apply')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitidentify.apply')}}">图文模式</a></li>
                        <li ><a href="{{route('admin.exhibitidentify.add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.exhibitcollect.apply_save')}}" class="form-horizontal ajaxForm">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">图片</label>
                                <div class="col-sm-10" id="poi_4_box">

                                    <div id="poi_4_picker">选择图片</div>
                                    @if(isset($exhibit) && $exhibit['squar_list_img'] != '')
                                        <div class="img-div">
                                            <img src="{{get_file_url($exhibit['squar_list_img'])}}"/>
                                            <span class="cancel">×</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="hidden" id="squar_list_img" name="squar_list_img" value="{{$exhibit['squar_list_img']  or ''}}"/>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">鉴定结果</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="id" id="id"
                                           value="{{$info['id'] or ''}}" required/>
                                    <input type="hidden" name="_token"
                                           value="{{csrf_token()}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">总登记号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="minor" id="minor"
                                           value="{{$info['minor'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="major"  name="major"
                                           value="{{$info['major'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">年代</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="rssia" name="rssia"
                                           value="{{$info['rssia'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">藏品级别</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="rssii" name="rssii"
                                           value="{{$info['rssii'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">藏品归属类别</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="distancea"  name="distancea"
                                           value="{{$info['distancea'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">质地</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">完残程度</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit">保存</button>
                                    <button class="btn btn-white" type="button" onclick="window.history.back()">返回
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="{{cdn('js/plugins/webuploader/webuploader.nolog.min.js')}}"></script>
    <script src="{{cdn('js/plugins/webuploader/webuploader_public.js')}}"></script>

    <script>
        //方形列表图
        singleUpload({
            _token: '{{csrf_token()}}',
            type_key: 'FT_ONE_RESOURCE',
            item_id: '{{$exhibit['exhibit_id'] or 0}}',
            pick: 'poi_4_picker',
            boxid: 'poi_4_box',
            file_path: 'squar_list_img',

        });
        $('#poi_4_box').find('.img-div>span').click(function () {
            sUploadDel($(this), 'poi_4')
        });
    </script>
@endsection


