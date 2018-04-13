@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.exhibitmanage.outstorageroom.oustorageapply')}}">查询</a></li>


                        <li class="active" ><a href="{{route('admin.exhibitmanage.outstorageroom.add_oustorageapply')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.exhibitmanage.outstorageroom.oustorageapply_save')}}" class="form-horizontal ajaxForm">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">申请部门名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="apply_depart_name" id="apply_depart_name"
                                           value="{{$info['apply_depart_name'] or ''}}" />
                                    <input type="hidden" class="form-control" name="exhibit_used_apply_id" id="exhibit_used_apply_id"
                                           value="{{$info['exhibit_used_apply_id'] or ''}}" />
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">经办人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="executer" id="executer"
                                           value="{{$info['executer'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">联系人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="connectioner" id="connectioner"
                                           value="{{$info['connectioner'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">联系方式</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="phone" id="phone"
                                           value="{{$info['phone'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">出库时间</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="outer_time" id="outer_time"
                                           value="{{$info['outer_time'] or ''}}" />
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">出库目的</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="outer_destination" id="outer_destination"
                                           value="{{$info['outer_destination'] or ''}}" />
                                </div>
                            </div>
                            <input type="hidden" name="exhibit_sum_register_id" id="exhibit_sum_register_ids" value="">
                            <iframe class="J_iframe" name="rIframe" id="rIframe" width="100%" height="100%" frameborder="0"
                                    src="{{route('admin.exhibitidentify.get_exhibit_list')}}"></iframe>
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


