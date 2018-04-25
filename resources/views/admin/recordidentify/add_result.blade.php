@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">



        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.identifyresult.save_result')}}" class="form-horizontal">
                            <input type="hidden" name="_token"
                                   value="{{csrf_token()}}" />
                            <input type="hidden" name="identify_apply_id"
                                   value="{{$identify_apply_id}}" />
                            <div class="form-group">
                                <label class="col-sm-2 control-label">选择藏品</label>
                                <div class="col-sm-4">
                                    <select name="exhibit_sum_register_id" class="form-control">
                                        @foreach($exhibit_list as $item)
                                            <option value="{{$item->exhibit_sum_register_id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">鉴定结果</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="identify_result" id="identify_result"
                                           value="{{$info['identify_result'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="name"  name="name"
                                           value="{{$info['name'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">年代</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="age" name="age"
                                           value="{{$info['age'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">藏品类别</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="type" name="type"
                                           value="{{$info['type'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">藏品级别</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="exhibit_level" name="exhibit_level"
                                           value="{{$info['exhibit_level'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">藏品质地</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="quality" name="quality"
                                           value="{{$info['quality'] or ''}}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">完残程度</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="complete_degree" name="complete_degree"
                                           value="{{$info['complete_degree'] or ''}}" />
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">图片</label>
                                <div class="col-sm-10" id="poi_4_box">

                                    <div id="poi_4_picker">选择图片</div>
                                    @if(isset($info) && $info['files'] != '')
                                        <div class="img-div">
                                            <img src="{{get_file_url($info['files'])}}"/>
                                            <span class="cancel">×</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="hidden" id="files" name="files" value="{{$info['files']  or ''}}"/>
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


