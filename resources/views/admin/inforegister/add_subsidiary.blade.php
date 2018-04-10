@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.inforegister.subsidiary')}}">查询</a></li>
                        <li><a href="{{route('admin.inforegister.subsidiary')}}">提交</a></li>
                        <li><a href="{{route('admin.inforegister.subsidiary')}}">导出</a></li>
                        <li><a href="{{route('admin.inforegister.subsidiary')}}">打印</a></li>
                        <li class="active"><a href="{{route('admin.inforegister.subsidiary.add')}}">新增</a></li></ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.inforegister.subsidiary.save')}}" class="form-horizontal">
                            <table  class="table" style="margin-left:8%;width:40%">
                                <tbody>
                                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                <input type="hidden" name="subsidiary_id" value="{{$data['subsidiary_id'] or ''}}" />
                                <tr><td>类型</td><td>
                                        <select name="type" class="form-control">
                                            @foreach(App\Models\Subsidiary::$type   as $k=>$name)
                                                <option value="{{$k}}" {{@$data['type']==$k||old('type')==$k?'selected':''}}>{{$name}}</option>
                                            @endforeach
                                        </select>
                                    </td></tr>
                                <tr>
                                    <td>收藏单位</td>
                                    <td colspan="3">
                                        <input type="text" class="form-control" name="collect_depart" value="{{$data['collect_depart'] or ''}}" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>附件</td>
                                    <td colspan="3">
                                        <div class="col-sm-3" id="poi_4_box">
                                            <div id="poi_4_picker">选择附件</div><br/>
                                            @if(isset($data) && $data['attachment'] != '')
                                                <div class="img-div">
                                                    <img src="{{get_file_url($data['attachment'])}}"/>
                                                    <span class="cancel">×</span>
                                                </div>
                                            @endif
                                        </div>
                                        <input type="hidden" id="files" name="attachment" value="{{$data['attachment']  or ''}}"/>
                                    </td>
                                </tr>

                                <tr><td colspan="4"><label class="control-label edit-title">登记号</label></td></tr>
                                <tr>
                                    <td>总登记号</td>
                                    <td><input type="text" class="form-control" name="exhibit_sum_register_num" value="{{$data['exhibit_sum_register_num'] or ''}}" /></td>
                                    <td>原编号</td>
                                    <td><input type="text" class="form-control" name="ori_num" value="{{$data['ori_num'] or ''}}" /></td>
                                </tr>
                                <tr>
                                    <td>分类号</td>
                                    <td><input type="text" class="form-control" name="type_num" value="{{$data['type_num'] or ''}}" /></td>
                                    <td>入馆登记号</td>
                                    <td><input type="text" class="form-control" name="collect_recipe_num" value="{{$data['collect_recipe_num'] or ''}}" /></td>
                                </tr>

                                <tr><td colspan="4"><label class="control-label edit-title">文物名称</label></td></tr>
                                <tr>
                                    <td>名称</td>
                                    <td><input type="text" class="form-control" name="name" value="{{$data['name'] or ''}}" /></td>
                                    <td>原名</td>
                                    <td><input type="text" class="form-control" name="ori_name" value="{{$data['ori_name'] or ''}}" /></td>
                                </tr>

                                <tr><td colspan="4"><label class="control-label edit-title">年代</label></td></tr>
                                <tr>
                                    <td>年代类型</td>
                                    <td><input type="text" class="form-control" name="age_type"  value="{{$data['age_type'] or ''}}" /></td>
                                    <td>具体年代</td>
                                    <td><input type="text" class="form-control" name="age" value="{{$data['age'] or ''}}" /></td>
                                </tr>
                                <tr>
                                    <td>历史阶段</td>
                                    <td><input type="text" class="form-control" name="history_step" value="{{$data['history_step'] or ''}}" /></td>
                                </tr>

                                <tr><td colspan="4"><label class="control-label edit-title">质地</label></td></tr>
                                <tr>
                                    <td>质地类型1</td>
                                    <td><input type="text" class="form-control" name="textaure1" value="{{$data['textaure1'] or ''}}" /></td>
                                    <td>质地类型2</td>
                                    <td><input type="text" class="form-control" name="textaure2" value="{{$data['textaure2'] or ''}}" /></td>
                                </tr>
                                <tr>
                                    <td>普查质地</td>
                                    <td><input type="text" class="form-control" name="common_textaure"  value="{{$data['common_textaure'] or ''}}" /></td>
                                    <td>具体质地</td>
                                    <td><input type="text" class="form-control" name="textaure"  value="{{$data['textaure'] or ''}}" /></td>
                                </tr>
                                <tr>
                                    <td>类别范围</td>
                                    <td><input type="text" class="form-control" name="range_type" value="{{$data['range_type'] or ''}}" /></td>
                                </tr>
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
            file_path: 'files',

        });
        $('#poi_4_box').find('.img-div>span').click(function () {
            sUploadDel($(this), 'poi_4')
        });
    </script>
@endsection


