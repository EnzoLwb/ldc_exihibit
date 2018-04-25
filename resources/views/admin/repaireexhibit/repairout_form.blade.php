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
                        <li><a href="{{route('admin.repaireexhibit.repairin.add')}}">新增内修文物</a></li>
                        @if(isset($data))
                            <li class="active"><a href="#">编辑内修文物</a></li>
                        @endif
                        <li><a href="{{route('admin.repaireexhibit.repairout')}}">外修文物管理</a></li>
                        <li @if(!isset($data))class="active"@endif><a href="{{route('admin.repaireexhibit.repairout.add')}}">新增外修文物</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="{{route('admin.repaireexhibit.repairout.save')}}" method="post" class="form-horizontal">
                            <input type="hidden" name="outside_repair_id" value="{{$data['outside_repair_id'] or ''}}" />
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
                                <label class="col-sm-2 control-label">账目类型</label>
                                <div class="col-sm-4">
                                    <select name="account_type" id="account_type" class="form-control">
                                        <option>请选择</option>
                                        @foreach(\App\Dao\ConstDao::$type_desc as $k=>$v)
                                            <option value="{{$k}}"
                                                    @if(isset($data)&&$k == $data['account_type']) selected @endif
                                            >{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">藏品名称(*)</label>
                                <div class="col-sm-4">
                                    <select name="exhibit_sum_register_id" id="exhibit_id" autocomplete="off" class="form-control">
                                        <option>请先选择账目类型</option>
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
                                <label class="col-sm-2 control-label">时间</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="pickup_date" name="date" value="{{$data['date']??old('date')}}"/>
                                </div>
                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">残缺情况</label>
                                <div class="col-sm-10">
                                    <textarea name="incomplete_status" class="form-control" cols="60" rows="4">{{$data['incomplete_status']??old('incomplete_status')}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复要求</label>
                                <div class="col-sm-10">
                                    <textarea name="repair_require" class="form-control" cols="60" rows="4">{{$data['repair_require']??old('repair_require')}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复数量</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  name="repair_num" value="{{$data['repair_num']??old('repair_num')}}"/>
                                </div>
                                @if ($errors->has('repair_num'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('repair_num') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">估价</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  name="plan_price" value="{{$data['plan_price']??old('plan_price')}}"/>
                                </div>
                                @if ($errors->has('plan_price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('plan_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">专家签字</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"  name="expert_signature" value="{{$data['expert_signature']??old('expert_signature')}}"/>
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
            var account_type=$('#account_type').val();
            $.ajax('{{route("admin.repaireexhibit.exhibit.detail")}}', {
                method: 'POST',
                data: {'exhibit_id':exhibit_id,'account_type':account_type},
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
        $('#account_type').change(function () {
            if ( $('#account_type').val()!=''){
                $.ajax('{{route("admin.accountmanage.repair_item_list")}}', {
                    method: 'get',
                    data: {'type': $("#account_type").val()},
                    dataType: 'json'
                }).done(function (response) {
                    len = response.data.length
                    $("#exhibit_id").html('<option>选择具体藏品</option>');
                    for (i=0;i<len;i++){
                        $("#exhibit_id").append("<option value='"+response.data[i].register_id+"'>"+response.data[i].name+"</option>");
                    }
                });
            }
        })
        //藏品详情 显示  绑定藏品信息
        $("#exhibit_id").bind("change",function () {
            //传入藏品名称给hidden
            $('#exhibit_name').val($('#exhibit_id option:selected').text());
            ajaxExhibitDetail();
        });

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
