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
                            <input type="hidden" name="exhibit_sum_register_id" value="{{$info['exhibit_sum_register_id']}}">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <table  class="table" style="margin-left:8%;width:40%">
                                <tbody>

                                <tr ><td colspan="4"><label class="control-label edit-title">登记号</label></td></tr>
                                <tr><td>总登记号</td><td><input type="text" class="form-control" name="exhibit_sum_register_num" id="exhibit_sum_register_num"
                                                            value="{{$info['exhibit_sum_register_num'] or ''}}" /></td>
                                    <td>入馆凭证号</td><td><input type="text" class="form-control" name="collect_recipe_num" id="collect_recipe_num"
                                                           value="{{$info['collect_recipe_num'] or ''}}" /></td>
                                </tr>

                                <tr ><td colspan="4"><label class="control-label edit-title">文物详细</label></td></tr>

                                <tr><td>名称</td><td><input type="text" class="form-control" name="name" id="name"
                                                          value="{{$info['name'] or ''}}" /></td>
                                    <td>数量</td><td><input type="number" class="form-control" name="num" id="num"
                                                          value="{{$info['num'] or ''}}" /></td>
                                </tr>



                                <tr><td>年代</td><td><input type="text" class="form-control" name="age" id="age"
                                                            value="{{$info['age'] or ''}}" /></td>
                                    <td>级别</td><td><input type="text" class="form-control" name="exhibit_level" id="exhibit_level"
                                                            value="{{$info['exhibit_level'] or ''}}" /></td>
                                </tr>
                                <tr><td>尺寸</td><td><input type="text" class="form-control" name="size" id="size"
                                                            value="{{$info['size'] or ''}}" /></td>
                                    <td >重量</td><td><input type="text" class="form-control" name="quality" id="quality"
                                                           value="{{$info['quality'] or ''}}" /></td></tr>

                                <tr><td>完残情况</td><td><input type="text" class="form-control" name="complete_degree" id="complete_degree"
                                                             value="{{$info['complete_degree'] or ''}}" /></td>
                                    <td>分库号</td><td><input type="text" class="form-control" name="room_number" id="room_number"
                                                             value="{{$info['room_number'] or ''}}" /></td>
                                </tr>

                                <tr><td>备注</td><td colspan="3"><textarea class="form-control" name="backup">{{$info['backup']}}</textarea></td>

                                </tr>
                                <tr ><td colspan="4"><label class="control-label edit-title">入库信息</label></td></tr>

                                <tr><td>入馆日期</td><td><input type="text" class="form-control" name="in_museum_time" id="in_museum_time"
                                                          value="{{$info['in_museum_time'] or ''}}" /></td>
                                    <td>来源</td><td><input type="text" class="form-control" name="src" id="src"
                                                          value="{{$info['src'] or ''}}" /></td>
                                </tr>
                                <tr><td>收据号</td><td><input type="text" class="form-control"name="recipe_num" value="{{$info['recipe_num']}}" readonly></td></tr>

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


