@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.exhibitidentify.exhibit')}}">查询</a></li>
                        <li class="active"><a href="{{route('admin.exhibitidentify.add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.exhibitidentify.apply_save')}}" class="form-horizontal ajaxForm">


                            <div class="form-group">
                                <label class="col-sm-2 control-label">登记日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="register_date" id="register_date"
                                           value="{{$info['register_date'] or ''}}" required/>

                                    <input type="hidden" class="form-control" name="identify_apply_id" id="identify_apply_id"
                                           value="{{$info['identify_apply_id'] or 0}}" required/>
                                    <input type="hidden" name="_token"
                                           value="{{csrf_token()}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">鉴定申请单名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="identify_apply_depart" id="identify_apply_depart"
                                           value="{{$info['identify_apply_depart'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">拟鉴定日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="identify_date"  name="identify_date"
                                           value="{{$info['identify_date'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">拟鉴定专家</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="identify_expert" name="identify_expert"
                                           value="{{$info['identify_expert'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">拟鉴定单位</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="identify_depart" name="identify_depart"
                                           value="{{$info['identify_depart'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">登记人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="register" name="register"
                                           value="{{$info['register'] or ''}}" required/>
                                </div>
                            </div>
                            <input type="hidden" name="exhibit_sum_register_id" id="exhibit_sum_register_ids" value="">
                            <iframe class="J_iframe" name="rIframe" id="rIframe" width="100%" height="100%" frameborder="0" src="{{route('admin.exhibitidentify.get_exhibit_list')}}"></iframe>

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
        function test() {
            select_exhibit_ids = [];
            input_length = $($(window.frames["rIframe"].document).find("input")).length
            for(i=0;i<input_length;i++){
                if($($($(window.frames["rIframe"].document).find("input"))[i]).is(':checked')){
                    select_exhibit_ids.push($($($(window.frames["rIframe"].document).find("input"))[i]).val())
                }
            }
        }

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


