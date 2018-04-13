@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.exhibitmanage.exhibitbackroom')}}">查询</a></li>

                        <li class="active"><a href="{{route('admin.exhibitmanage.add_exhibitbackroom')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.exhibitmanage.save_exhibitbackroom')}}" class="form-horizontal ajaxForm">
                            <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                            <input type="hidden" value="{{$info['return_storage_id']}}" name="return_storage_id"/>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文物名称</label>
                                <div class="col-sm-4">
                                    <select name="exhibit_sum_register_id" class="form-control">
                                        @foreach($exhibit_list as $item)
                                            <option value="{{$item['exhibit_sum_register_id']}}">{{$item['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">退换人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="returner" id="returner"
                                           value="{{$info['returner'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">点收人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="taker" id="taker"
                                           value="{{$info['taker'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">退换日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="return_date" id="return_date"
                                           value="{{$info['return_date'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">备注</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" name="mark">{{$info['mark']}}</textarea>
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


