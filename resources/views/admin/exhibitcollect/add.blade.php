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

                        <li class="active"><a href="{{route('admin.exhibitcollect.add')}}">{{$title}}</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.exhibitcollect.apply_save')}}" class="form-horizontal ajaxForm">
                            <input type="hidden" name="collect_apply_id"
                                   value="{{$info['collect_apply_id'] or 0}}" />
                            <input type="hidden" name="_token"
                                   value="{{csrf_token()}}" />
                            <div class="form-group">
                                <label class="col-sm-2 control-label">登记日期</label>
                                <div class="col-sm-4">

                                    <input placeholder="开始日期" class="form-control layer-date laydate-icon" id="register_date" type="text" name="register_date" value="{{request('register_date')}}"
                                           style="width: 140px;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">征集申请单号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="collect_apply_num" id="collect_apply_num"
                                           value="{{$info['collect_apply_num'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">征集申请单位名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="collect_apply_depart_name"  name="collect_apply_depart_name"
                                           value="{{$info['collect_apply_depart_name'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">征集采购对象</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="collect_buy_object" name="collect_buy_object"
                                           value="{{$info['collect_buy_object'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">申请征集项目名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="collect_apply_project_name" name="collect_apply_project_name"
                                           value="{{$info['collect_apply_project_name'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">申请部门</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="apply_depart" name="apply_depart"
                                           value="{{$info['apply_depart'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">所需征集经费</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="need_fee" name="need_fee"
                                           value="{{$info['need_fee'] or ''}}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">申请征集数量</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="collect_exhibit_count" name="collect_exhibit_count"
                                           value="{{$info['collect_exhibit_count'] or ''}}" />
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">申请人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="applyer" name="applyer"
                                           value="{{$info['applyer'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">具体征集项目介绍</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="collect_project_desc" name="collect_project_desc"
                                           value="{{$info['collect_project_desc'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">征集原因</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="collect_reason" name="collect_reason"
                                           value="{{$info['collect_reason'] or ''}}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">附件</label>
                                <div class="col-sm-10" id="poi_4_box">

                                    <div id="poi_4_picker">选择附件</div>
                                    @if(isset($info) && $info['files'] != '')
                                        <div class="img-div">
                                            <img src="{{get_file_url($info['files'])}}"/>
                                            <span class="cancel">×</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="hidden" id="files" name="files" value="{{$info['files']  or ''}}"/>
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
    <script src="{{cdn('js/public.js')}}"></script>
    <script type="text/javascript" src="{{cdn('js/plugins/laydate/laydate.js')}}"></script>
    <script>
        var start = $.extend({}, laydateOptions, {
            elem: "#register_date",
            choose: function (datas) {
            }
        });
        laydate(start);
        //方形列表图
        singleUpload({
            _token: '{{csrf_token()}}',
            type_key: 'FT_ONE_RESOURCE',
            item_id: '{{$info['exhibit_id'] or 0}}',
            pick: 'poi_4_picker',
            boxid: 'poi_4_box',
            file_path: 'files',

        });
        $('#poi_4_box').find('.img-div>span').click(function () {
            sUploadDel($(this), 'poi_4')
        });
    </script>
@endsection


