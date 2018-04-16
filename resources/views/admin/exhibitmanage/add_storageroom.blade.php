@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.exhibitmanage.storageroom')}}">查询</a></li>
                        <li class="active" ><a href="{{route('admin.exhibitmanage.add_storageroom')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.exhibitmanage.storage_room_save')}}" class="form-horizontal ajaxForm">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">仓库名称</label>
                                <div class="col-sm-4">
                                    <select name="room_number" id="room_number" class="form-control" >
                                        @foreach($exhibit_list as $item)
                                            <option value="{{$item->room_number}}">{{$item->room_name}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="_token"
                                           value="{{csrf_token()}}" />
                                    <input type="hidden" name="exhibit_sum_register_id"
                                           value="{{$exhibit_sum_register_id}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">排架列表</label>
                                <div class="col-sm-4">
                                    <select name="frame_id" id="frame_id" class="form-control" >

                                    </select>
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
        var frame_id = "{{$info['frame_id']}}"
        $.ajax('{{route("admin.exhibitmanage.frame_list")}}', {
            method: 'get',
            data: {'room_number': $("#room_number").val()},
            dataType: 'json'
        }).done(function (response) {
            len = response.data.length
            for (i=0;i<len;i++){
                is_select = false;
                if(frame_id == response.data[i].frame_id){
                    is_select = true;
                }
                if(is_select){
                    $("#frame_id").append("<option selected value='"+response.data[i].frame_id+"'>"+response.data[i].frame_name+"</option>");
                }else{
                    $("#frame_id").append("<option value='"+response.data[i].frame_id+"'>"+response.data[i].frame_name+"</option>");
                }

            }
        });
        $("#room_number").change(function(){
            $.ajax('{{route("admin.exhibitmanage.frame_list")}}', {
                method: 'get',
                data: {'room_number': $("#room_number").val()},
                dataType: 'json'
            }).done(function (response) {
                len = response.data.length
                for (i=0;i<len;i++){
                    is_select = false;
                    if(frame_id == response.data[i].frame_id){
                        is_select = true;
                    }
                    if(is_select){
                        $("#frame_id").append("<option selected value='"+response.data[i].frame_id+"'>"+response.data[i].frame_name+"</option>");
                    }else{
                        $("#frame_id").append("<option value='"+response.data[i].frame_id+"'>"+response.data[i].frame_name+"</option>");
                    }

                }
            });
        });
    </script>
@endsection


