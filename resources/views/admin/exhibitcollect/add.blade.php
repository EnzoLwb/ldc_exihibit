@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.exhibitcollect.apply')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitcollect.apply')}}">修改</a></li>
                        <li><a href="{{route('admin.exhibitcollect.apply')}}">删除</a></li>
                        <li><a href="{{route('admin.exhibitcollect.apply')}}">送鉴定</a></li>
                        <li><a href="{{route('admin.exhibitcollect.apply')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitcollect.apply')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitcollect.apply')}}">图文模式</a></li>
                        <li class="active"><a href="{{route('admin.exhibitcollect.apply')}}">新增</a></li>
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
                                <label class="col-sm-2 control-label">征集日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="id" id="id"
                                           value="{{$info['id'] or ''}}" required/>
                                    <input type="hidden" name="_token"
                                           value="{{csrf_token()}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">征集申请单号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="minor" id="minor"
                                           value="{{$info['minor'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">征集申请单位名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="major"  name="major"
                                           value="{{$info['major'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">征集采购对象</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="rssia" name="rssia"
                                           value="{{$info['rssia'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">申请征集项目名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="rssii" name="rssii"
                                           value="{{$info['rssii'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">申请部门</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="distancea"  name="distancea"
                                           value="{{$info['distancea'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">所需征集经费</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">申请人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">具体征集项目介绍</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">征集原因</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">附件</label>
                                <div class="col-sm-10" id="poi_4_box">

                                    <div id="poi_4_picker">选择附件</div>
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


