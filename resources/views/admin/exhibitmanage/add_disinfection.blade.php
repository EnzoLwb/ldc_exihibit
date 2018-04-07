@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.exhibitmanage.disinfection')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitmanage.disinfection')}}">修改</a></li>
                        <li><a href="{{route('admin.exhibitmanage.disinfection')}}">删除</a></li>
                        <li class="active" ><a href="{{route('admin.exhibitmanage.add_disinfection')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.exhibitmanage.disinfection_save')}}" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">藏品名称</label>
                                <div class="col-sm-4">
                                    <select name="exhibit_sum_register_id" class="form-control">
                                        @foreach($exhibit_list as $exhibit)

                                            <option
                                                    value="{{$exhibit['exhibit_sum_register_id']}}">
                                                {{$exhibit['name']}}
                                            </option>
                                        @endforeach

                                    </select>
                                    <input type="hidden" class="form-control" name="disinfection_id" id="disinfection_id"
                                           value="{{$info['disinfection_id'] or ''}}" required/>
                                    <input type="hidden" class="form-control" name="_token" id="_token"
                                           value="{{csrf_token()}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">清洁方式</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="clean_way" id="clean_way"
                                           value="{{$info['clean_way'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">消毒方式</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="disinfection_way" id="disinfection_way"
                                           value="{{$info['disinfection_way'] or ''}}" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">清洁日期</label>
                                <div class="col-sm-4">
                                    <input placeholder="清洁日期" class="form-control layer-date laydate-icon" id="clean_date" type="text" name="clean_date"
                                           value="{{request('clean_date')}}"
                                           style="width: 140px;">
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
            elem: "#clean_date",
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


