@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.inforegister.subsidiary')}}">查询</a></li>
                        <li><a href="{{route('admin.inforegister.subsidiary')}}">修改</a></li>
                        <li><a href="{{route('admin.inforegister.subsidiary')}}">删除</a></li>
                        <li><a href="{{route('admin.inforegister.subsidiary')}}">提交</a></li>
                        <li><a href="{{route('admin.inforegister.subsidiary')}}">导出</a></li>
                        <li><a href="{{route('admin.inforegister.subsidiary')}}">打印</a></li>
                        <li><a href="{{route('admin.inforegister.subsidiary')}}">图文模式</a></li>
                        <li class="active"><a href="{{route('admin.inforegister.add_subsidiary')}}">新增</a></li></ul>
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
                                <label class="col-sm-2 control-label">收藏单位</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">总登记号</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">原编号</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">分类号</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">入馆登记号</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">名称</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">原名</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">年代类型</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">具体年代</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">历史阶段</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">质地</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">质地类型1</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">质地类型2</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">普查质地</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">具体质地</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">类别范围</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
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

