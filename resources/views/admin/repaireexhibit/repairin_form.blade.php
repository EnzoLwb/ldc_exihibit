@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">
@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.repaireexhibit.repairin')}}">内修文物管理</a></li>
                        <li @if(!isset($data))class="active"@endif><a href="{{route('admin.repaireexhibit.repairin.add')}}">新增内修文物</a></li>
                        @if(isset($data))
                            <li class="active"><a href="#">编辑内修文物</a></li>
                        @endif
                        <li><a href="{{route('admin.repaireexhibit.repairout')}}">外修文物管理</a></li>
                        <li><a href="{{route('admin.repaireexhibit.repairout.add')}}">新增外修文物</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="{{route('admin.repaireexhibit.repairin.save')}}" method="post" class="form-horizontal">
                            <input type="hidden" name="inside_repair_id" value="{{$data['inside_repair_id'] or ''}}" />
                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复前</label>
                                <div class="col-sm-3" id="poi_1_box">
                                    <div id="poi_1_picker">更换图片</div><br/>
                                    @if(isset($data) && $data['before_pic'] != ''||old('before_pic'))
                                        <div class="img-div">
                                            <img src="{{get_file_url($data['before_pic']??old('before_pic'))}}"/>
                                            <span class="cancel">×</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="hidden" id="files_1" name="before_pic" value="{{$data['before_pic']  or ''}}"/>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复中</label>
                                <div class="col-sm-3" id="poi_2_box">
                                    <div id="poi_2_picker">更换图片</div><br/>
                                    @if(isset($data) && $data['repairing_pic'] != ''||old('repairing_pic'))
                                        <div class="img-div">
                                            <img src="{{get_file_url($data['repairing_pic']??old('repairing_pic'))}}"/>
                                            <span class="cancel">×</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="hidden" id="files_2" name="repairing_pic" value="{{$data['repairing_pic']  or ''}}"/>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复后</label>
                                <div class="col-sm-3" id="poi_3_box">
                                    <div id="poi_3_picker">更换图片</div><br/>
                                    @if(isset($data) && $data['after_pic'] != ''||old('after_pic'))
                                        <div class="img-div">
                                            <img src="{{get_file_url($data['after_pic']??old('after_pic'))}}"/>
                                            <span class="cancel">×</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="hidden" id="files_3" name="after_pic" value="{{$data['after_pic']  or ''}}"/>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">档案号(*)</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="repair_order_name" value="{{$data['repair_order_name']??old('repair_order_name')}}"/>
                                </div>
                                @if ($errors->has('repair_order_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('repair_order_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">藏品名称(*)</label>
                                <div class="col-sm-4">
                                    <select name="exhibit_sum_register_id" id="exhibit_id" autocomplete="off" class="form-control">
                                        @foreach($exhibit as $v)
                                            <option value="{{$v['exhibit_id']}}" {{@$data['exhibit_sum_register_id']==$v['exhibit_id']||old('exhibit_sum_register_id')==$v['exhibit_id']?'selected':''}}>{{$v['name']}}</option>
                                        @endforeach
                                    </select><br/>
                                    <input type="hidden" value="" name="name" id="exhibit_name">
                                    分类号   <input class="form-control" id="type_no" type="text" placeholder="选择藏品" disabled>
                                    年代     <input class="form-control" id="age" type="text" placeholder="选择藏品" disabled>
                                    质地     <input class="form-control" id="quality" type="text" placeholder="选择藏品" disabled>
                                    藏品级别 <input class="form-control" id="level" type="text" placeholder="选择藏品" disabled>
                                    器物尺寸 <input class="form-control" id="size" type="text" placeholder="选择藏品" disabled>
                                    重量     <input class="form-control" id="weight" type="text" placeholder="选择藏品" disabled>
                                </div>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">提取日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="pickup_date" name="pickup_date" value="{{$data['pickup_date']??old('pickup_date')}}"/>
                                </div>
                                @if ($errors->has('pickup_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pickup_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">归还时间</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="return_date" name="return_date" value="{{$data['return_date']??old('return_date')}}"/>
                                </div>
                                @if ($errors->has('return_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('return_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">主持人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="host" value="{{$data['host']??old('host')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="restorer" value="{{$data['restorer']??old('restorer')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">主任签字</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="header_signature" value="{{$data['header_signature']??old('header_signature')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">馆长签字</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="curator_signature" value="{{$data['curator_signature']??old('curator_signature')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文物现状</label>
                                <div class="col-sm-10">
                                    <textarea name="exhibit_status" class="form-control" cols="60" rows="4">{{$data['exhibit_status']??old('exhibit_status')}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复要求</label>
                                <div class="col-sm-10">
                                    <textarea name="repair_demand" class="form-control" cols="60" rows="4">{{$data['repair_demand']??old('repair_demand')}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复历史</label>
                                <div class="col-sm-10">
                                    <textarea name="repair_history" class="form-control" cols="60" rows="4">{{$data['repair_history']??old('repair_history')}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复方案</label>
                                <div class="col-sm-10">
                                    <textarea name="repair_scheme" class="form-control" cols="60" rows="4">{{$data['repair_scheme']??old('repair_scheme')}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复经过及使用材料</label>
                                <div class="col-sm-10">
                                    <textarea name="process_data" class="form-control" cols="60" rows="4">{{$data['process_data']??old('process_data')}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">检验结果</label>
                                <div class="col-sm-4">
                                    <textarea name="result" class="form-control" cols="60" rows="4">{{$data['result']??old('result')}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">方案制定人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="scheme_editor" value="{{$data['scheme_editor']??old('scheme_editor')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">方案审定人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="scheme_checker" value="{{$data['scheme_checker']??old('scheme_checker')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">验收人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="acceptor" value="{{$data['acceptor']??old('acceptor')}}"/>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit">保存</button>
                                    <button class="btn btn-white" type="button" id="backBtn">返回</button>
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
    <script type="text/javascript" src="{{cdn('js/plugins/laydate_new/laydate.js')}}"></script>
    <script>

        //查询商品详情
        function ajaxExhibitDetail() {
            var exhibit_id=$("#exhibit_id").val();
            $.ajax('{{route("admin.repaireexhibit.exhibit.detail")}}', {
                method: 'POST',
                data: {'exhibit_id':exhibit_id},
                dataType: 'json'
            }).done(function (response) {
                $('#type_no').val(response.type_no);
                $('#quality').val(response.quality);
                $('#level').val(response.level);
                $('#age').val(response.age);
                $('#size').val(response.size);
                $('#weight').val(response.weight);
            });
        }
        //藏品详情 显示  绑定藏品信息
        $(function(){
            $('#exhibit_name').val($('#exhibit_id option:selected').text());
            ajaxExhibitDetail();
            $("#exhibit_id").bind("change",function () {
                //传入藏品名称给hidden
                $('#exhibit_name').val($('#exhibit_id option:selected').text());
                ajaxExhibitDetail();
            });
        });
            //时间js
        var pickup_date = laydate.render({
            elem: '#pickup_date',
            type: 'datetime',
            min: '1999-1-1 00:00:00',
            max: '2099-6-16 23:59:59',
            done: function(value, date){
                //限制归还的时间不能低于提取时间（只是显示）后台还要再验证
                return_date.config.min = {
                    date:date.date,
                    hours:date.hours,
                    minutes:date.minutes+1,
                    month:date.month-1,
                    seconds:date.seconds,
                    year:date.year
                };
            }
        });
        var return_date = laydate.render({
            elem: '#return_date',
            type: 'datetime',
            min: '1999-1-1 00:00:00',
            max: '2099-6-16 23:59:59',
            done: function(value, date){
                pickup_date.config.max = {
                    year: date.year,
                    month: date.month - 1,
                    date: date.date,
                    hours: date.hours,
                    minutes: date.minutes,
                    seconds: date.seconds
                }; //结束日选好后，重置开始日的最大日期
            }
        });
        //修复图片上传
        singleUpload({
            _token: '{{csrf_token()}}',
            type_key: 'FT_ONE_RESOURCE',
            item_id: '{{$info['exhibit_id'] or 0}}',
            pick: 'poi_3_picker',
            boxid: 'poi_3_box',
            file_path: 'files_3',

        });
        singleUpload({
            _token: '{{csrf_token()}}',
            type_key: 'FT_ONE_RESOURCE',
            item_id: '{{$info['exhibit_id'] or 0}}',
            pick: 'poi_1_picker',
            boxid: 'poi_1_box',
            file_path: 'files_1',

        });
        singleUpload({
            _token: '{{csrf_token()}}',
            type_key: 'FT_ONE_RESOURCE',
            item_id: '{{$info['exhibit_id'] or 0}}',
            pick: 'poi_2_picker',
            boxid: 'poi_2_box',
            file_path: 'files_2',

        });
        //图片删除
        $('#poi_1_box').find('.img-div>span').click(function () {
            sUploadDel($(this), 'poi_1')
        });
        $('#poi_2_box').find('.img-div>span').click(function () {
            sUploadDel($(this), 'poi_2')
        });
        $('#poi_3_box').find('.img-div>span').click(function () {
            sUploadDel($(this), 'poi_3')
        });
    </script>
@endsection
