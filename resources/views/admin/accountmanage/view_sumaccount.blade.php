@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">
@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.inforegister.exhibitmanage')}}">查询</a></li>
                        
                        <li class="active"><a href="{{route('admin.inforegister.add_exhibit')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <td class="col-sm-12">
            <td class="ibox float-e-margins">
                <tr class="ibox-content">
                    <form method="post" action="{{route('admin.inforegister.fake_exhibit_save')}}" class="form-horizontal ajaxForm">

                        <table  class="table" style="margin-left:8%;width:40%">
                            <tbody>
                            <tr>
                                <td>收藏单位</td>
                                <td colspan="3">
                                    <input type="text" class="form-control" name="collect_depart_name" id="collect_depart_name"
                                           value="{{$info['collect_depart_name'] or ''}}" readonly />
                                    <input type="hidden" name="_token"
                                           value="{{csrf_token()}}" />
                                    <input type="hidden" name="fake_exhibit_sum_register_id"
                                           value="{{$info['fake_exhibit_sum_register_id']}}" />
                                </td>
                            </tr>
                            <tr>
                                <td>附件</td>
                                <td colspan="3">


                                    <div class="form-group">

                                        <div class="col-sm-10" id="poi_4_box">


                                            @if(isset($info) && $info['files'] != '')
                                                <div class="img-div">
                                                    <img src="{{get_file_url($info['files'])}}"/>
                                                    <span class="cancel">×</span>
                                                </div>
                                            @endif
                                        </div>
                                        <input type="hidden" id="files" name="files" value="{{$info['files']  or ''}}"/>
                                    </div>





                                </td>
                            </tr>
                            <tr ><td colspan="4"><label class="control-label edit-title">登记号</label></td></tr>
                            <tr><td>总登记号</td><td><input type="text" class="form-control" name="exhibit_sum_register_num" id="exhibit_sum_register_num"
                                                        value="{{$info['exhibit_sum_register_num'] or ''}}" readonly/></td>
                                <td>原编号</td><td><input type="text" class="form-control" name="ori_num" id="ori_num"
                                                       value="{{$info['ori_num'] or ''}}" readonly/></td>
                            </tr>
                            <tr><td>曾用号</td><td><input type="text" class="form-control" name="used_num" id="used_num"
                                                       value="{{$info['used_num'] or ''}}" readonly /></td>

                                <td>入馆凭证</td><td><input type="text" class="form-control" name="collect_recipe_num" id="collect_recipe_num"
                                                        value="{{$info['collect_recipe_num'] or ''}}" readonly /></td>
                            </tr>

                            <tr ><td colspan="4"><label class="control-label edit-title">文物名称</label></td></tr>

                            <tr><td>现用名</td><td><input type="text" class="form-control" name="name" id="name"
                                                       value="{{$info['name'] or ''}}" readonly/></td>
                                <td>曾用名</td><td><input type="text" class="form-control" name="used_name" id="used_name"
                                                       value="{{$info['used_name'] or ''}}" readonly /></td>
                            </tr>

                            <tr ><td colspan="4"><label class="control-label edit-title">年代</label></td></tr>

                            <tr><td>年代类型</td><td><input type="text" class="form-control" name="age_type" id="age_type"
                                                        value="{{$info['age_type'] or ''}}" readonly /></td>
                                <td>具体年代</td><td><input type="text" class="form-control" name="age" id="age"
                                                        value="{{$info['age'] or ''}}" readonly /></td>
                            </tr>
                            <tr><td>历史阶段</td><td><input type="text" class="form-control" name="history_step" id="history_step"
                                                        value="{{$info['history_step'] or ''}}" readonly/></td>
                            </tr>
                            <tr ><td colspan="4"><label class="control-label edit-title">质地</label></td></tr>

                            <tr><td>质地类型1</td><td><input type="text" class="form-control" name="textaure1" id="textaure1"
                                                         value="{{$info['textaure1'] or ''}}" readonly/></td>
                                <td>质地类型2</td><td><input type="text" class="form-control" name="textaure2" id="textaure2"
                                                         value="{{$info['textaure2'] or ''}}"  readonly/></td>
                            </tr>
                            <tr><td>普查质地</td><td><input type="text" class="form-control" name="common_textaure" id="common_textaure"
                                                        value="{{$info['common_textaure'] or ''}}" readonly /></td>
                                <td>具体质地</td><td><input type="text" class="form-control" name="textaure" id="textaure"
                                                        value="{{$info['textaure'] or ''}}" readonly/></td>
                            </tr>

                            <tr ><td colspan="4"><label class="control-label edit-title">文物类别</label></td></tr>

                            <tr><td>类别范围</td><td><input type="text" class="form-control" name="range_type" id="range_type"
                                                        value="{{$info['range_type'] or ''}}" readonly /></td>
                                <td>具体类别</td><td><input type="text" class="form-control" name="type" id="type"
                                                        value="{{$info['type'] or ''}}"  readonly/></td>
                            </tr>

                            <tr ><td colspan="4"><label class="control-label edit-title">数量</label></td></tr>

                            <tr><td>传统数量</td><td><input type="text" class="form-control" name="common_num" id="common_num"
                                                        value="{{$info['common_num'] or ''}}" readonly/></td>
                                <td>传统数量单位</td><td><input type="text" class="form-control" name="common_num_uint" id="common_num_uint"
                                                          value="{{$info['common_num_uint'] or ''}}" readonly/></td>
                            </tr>
                            <tr><td>实际数量</td><td><input type="text" class="form-control" name="num" id="num"
                                                        value="{{$info['num'] or ''}}" readonly/></td>
                                <td>实际数量单位</td><td><input type="text" class="form-control" name="num_uint" id="num_uint"
                                                          value="{{$info['num_uint'] or ''}}" readonly/></td>
                            </tr>
                            <tr ><td colspan="4"><label class="control-label edit-title">质量</label></td></tr>

                            <tr><td>具体质量</td><td><input type="text" class="form-control" name="quality" id="quality"
                                                        value="{{$info['quality'] or ''}}" readonly /></td>
                                <td>质量范围</td><td><input type="text" class="form-control" name="quality_range" id="quality_range"
                                                        value="{{$info['quality_range'] or ''}}" readonly/></td>
                            </tr>

                            <tr ><td colspan="4"><label class="control-label edit-title">外形</label></td></tr>

                            <tr><td>尺寸</td><td><input type="text" class="form-control" name="size" id="size"
                                                      value="{{$info['size'] or ''}}"  readonly/></td>
                                <td>长宽高</td><td><input type="text" class="form-control" name="lwh" id="lwh"
                                                       value="{{$info['lwh'] or ''}}" readonly/></td>
                            </tr>

                            <tr><td >文物级别</td><td >
                                    <select name="exhibit_level" id="exhibit_level" class="form-control" readonly>
                                        @foreach(\App\Dao\ConstDao::$exhibit_level_desc as $item)
                                            <option value="{{$item}}"
                                                    @if($item == $info['exhibit_level']) selected @endif
                                            >
                                                {{$item}}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr ><td colspan="4"><label class="control-label edit-title">来源</label></td></tr>

                            <tr><td>来源方式</td><td><input type="text" class="form-control" name="src_way" id="src_way"
                                                        value="{{$info['src_way'] or ''}}"readonly /></td>
                                <td>具体来源</td><td><input type="text" class="form-control" name="src" id="src"
                                                        value="{{$info['src'] or ''}}" readonly/></td>
                            </tr>

                            <tr><td>来源补充</td><td><input type="text" class="form-control" name="src_addition" id="src_addition"
                                                        value="{{$info['src_addition'] or ''}}" readonly/></td></tr>

                            <tr ><td colspan="4"><label class="control-label edit-title">完残</label></td></tr>

                            <tr><td>完残程度</td><td><input type="text" class="form-control" name="complete_degree" id="complete_degree"
                                                        value="{{$info['complete_degree'] or ''}}" readonly/></td>
                                <td>完残状况</td><td><input type="text" class="form-control" name="complete_info" id="complete_info"
                                                        value="{{$info['complete_info'] or ''}}" readonly/></td>
                            </tr>


                            <tr><td>保存状态</td><td ><input type="text" class="form-control" name="storage_status" id="storage_status"
                                                         value="{{$info['storage_status'] or ''}}" readonly/></td></tr>
                            <tr ><td colspan="4"><label class="control-label edit-title">入馆时间</label></td></tr>
                            <tr><td>入藏具体时间</td><td ><input type="text" class="form-control" name="in_museum_time" id="in_museum_time"
                                                           value="{{$info['in_museum_time'] or ''}}" readonly/></td>
                                <td>入藏年代</td><td><input type="text" class="form-control" name="in_museum_age" id="in_museum_age"
                                                        value="{{$info['in_museum_age'] or ''}}" readonly/></td>
                            </tr>
                            <tr><td>入藏时间范围</td><td ><input type="text" class="form-control" name="in_museum_time_range" id="in_museum_time_range"
                                                           value="{{$info['in_museum_time_range'] or ''}}" readonly /></td></tr>
                            <tr ><td colspan="4"><label class="control-label edit-title">其他信息</label></td></tr>


                            <tr><td>具体存放地点</td><td><input type="text" class="form-control" name="storage_position" id="storage_position"
                                                          value="{{$info['storage_position'] or ''}}" readonly/></td>
                                <td>原展厅具体位置</td><td><input type="text" class="form-control" name="ori_storage_position" id="ori_storage_position"
                                                           value="{{$info['ori_storage_position'] or ''}}" readonly/></td>
                            </tr>
                            <tr><td>展厅柜号</td><td><input type="text" class="form-control" name="room_gui_num" id="room_gui_num"
                                                        value="{{$info['room_gui_num'] or ''}}" readonly /></td>
                                <td>藏品性质</td><td><input type="text" class="form-control" name="exhibit_property" id="exhibit_property"
                                                        value="{{$info['exhibit_property'] or ''}}" readonly/></td>
                            </tr>


                            <td>藏品状态</td><td>
                                <select class="form-control" name="status" readonly>
                                    @foreach(\App\Dao\ConstDao::$exhibit_status_desc as $k=>$v)

                                        <option value="{{$k}}"     @if($info['status'] == $k) selected
                                                @endif>{{$v}}</option>
                                    @endforeach
                                </select>

                            </td>
                            </tr>

                            <tr><td>备注</td><td colspan="3">
                                    <textarea readonly class="form-control">{{$info['backup'] or ''}}</textarea>
                                </td>
                            </tr>
                            </tbody>
                        </table>


                    </form>
        </div>
    </div>

    <script src="{{cdn('js/plugins/webuploader/webuploader.nolog.min.js')}}"></script>
    <script src="{{cdn('js/plugins/webuploader/webuploader_public.js')}}"></script>

    <script>
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


