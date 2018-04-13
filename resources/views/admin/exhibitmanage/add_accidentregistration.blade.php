@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.exhibitmanage.accidentregistration')}}">查询</a></li>

                        <li  class="active"><a href="{{route('admin.exhibitmanage.add_accidentregistration')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.exhibitmanage.accidentregistration_save')}}" class="form-horizontal">

                            <input type="hidden" name="accident_id" value="{{$info['accident_id'] or ''}}">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文物选择</label>
                                <div class="col-sm-4">
                                    <select name="exhibit_sum_register_id" class="form-control">
                                        @foreach($exhibit_list as $exhibit)
                                            <option value="{{$exhibit->exhibit_sum_register_id}}">{{$exhibit->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">事故时间</label>
                                <div class="col-sm-4">
                                    <input placeholder="事故时间" class="form-control layer-date laydate-icon" id="accident_time" type="text"
                                           name="accident_time" value="{{$info['accident_time']}}"
                                           style="width: 140px;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">事故人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="accident_maker" id="accident_maker"
                                           value="{{$info['accident_time'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">事故描述</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" name="accident_desc">{{$info['accident_desc'] or ''}}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">处理依据</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" name="proc_dependy">{{$info['proc_dependy'] or ''}}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">处理意见</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" name="proc_suggestion">{{$info['proc_suggestion'] or ''}}</textarea>
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
    <script src="{{cdn('js/public.js')}}"></script>
    <script type="text/javascript" src="{{cdn('js/plugins/laydate/laydate.js')}}"></script>
    <script>
        var start = $.extend({}, laydateOptions, {
            elem: "#accident_time",
            choose: function (datas) {
            }
        });
        laydate(start);
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


