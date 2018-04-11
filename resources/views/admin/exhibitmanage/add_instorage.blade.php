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
                        <li><a href="{{route('admin.exhibitmanage.instorageroom')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.instorageroom')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitmanage.instorageroom')}}">图文模式</a></li>
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
                                    <td>库房名称</td>
                                    <td>
                                        <select name="room_number" class="form-control">
                                            @foreach($room_list as $item)
                                                <option @if($item['room_number'] == $info['room_number']) selected @endif value="{{$item['room_number']}}">{{$item['room_name']}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>展品名称</td>
                                    <td>
                                        <select name="exhibit_sum_register_id" class="form-control">
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
    </script>
@endsection


