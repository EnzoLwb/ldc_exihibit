@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.exhibitmanage.instorageroom')}}">查询</a></li>
                        <li class="active" ><a href="{{route('admin.exhibitmanage.add_instorageroom')}}">编辑</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.exhibitmanage.instorageroom_save')}}" class="form-horizontal">
                            <input type="hidden" name="exhibit_into_room_id" value="{{$info['exhibit_into_room_id'] or 0}}">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <table  class="table" style="margin-left:8%;width:40%">
                                <tbody>
                                <tr ><td colspan="4"><label class="control-label edit-title">入库信息</label></td></tr>
                                <tr>
                                    <td>类型</td>
                                    <td>
                                        <select name="type" id="type" class="form-control">
                                            @foreach(\App\Dao\ConstDao::$type_desc as $k=>$v)
                                                <option value="{{$k}}"
                                                        @if($k == $info['type']) selected @endif
                                                >{{$v}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>库房名称</td>
                                    <td>
                                        <select name="room_number" id="room_number" class="form-control">
                                            @foreach($room_list as $item)
                                                <option @if($item['room_number'] == $info['room_number']) selected @endif value="{{$item['room_number']}}">{{$item['room_name']}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>排架名称</td>
                                    <td>
                                        <select name="frame_id" id="frame_id" class="form-control">
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>展品名称</td>
                                    <td>
                                        <select name="exhibit_sum_register_id" id="exhibit_sum_register_id" class="form-control">
                                            @foreach($exhibit_list as $item)
                                                <option @if($item['exhibit_sum_register_id'] == $info['exhibit_sum_register_id']) selected @endif value="{{$item['exhibit_sum_register_id']}}">{{$item['name']}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>

                                <tr><td>入库凭证号</td><td><input type="text" class="form-control"name="in_room_recipe_num"
                                                             value="{{$info['in_room_recipe_num']}}" ></td></tr>

                                </tbody>
                            </table>


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
        function frame_list(){
            $.ajax('{{route("admin.exhibitmanage.frame_list")}}', {
                method: 'get',
                data: {'room_number': $("#room_number").val()},
                dataType: 'json'
            }).done(function (response) {
                $("#frame_id").html('')
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
        }
        frame_list();
        $("#room_number").change(function(){
            frame_list();
        })

        //获得不同类型的账目明细
        function get_item_list() {
            $.ajax('{{route("admin.accountmanage.item_list")}}', {
                method: 'get',
                data: {'type': $("#type").val()},
                dataType: 'json'
            }).done(function (response) {
                len = response.data.length
                $("#exhibit_sum_register_id").html('');
                for (i=0;i<len;i++){
                    if(response.data[i].room_number.length == 0){
                        $("#exhibit_sum_register_id").append("<option value='"+response.data[i].register_id+"'>"+response.data[i].name+"</option>");
                    }

                }
            });
        }
        get_item_list();
        $("#type").change(function(){
            get_item_list();
        });
    </script>
@endsection


