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
                        <li class="active"><a href="#">查看内修文物</a></li>
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
                            <input type="hidden" name="inside_repair_id" value="{{$info['inside_repair_id'] or ''}}" />
                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复前</label>
                                <div class="col-sm-3" id="poi_1_box">
                                    @if($data['before_pic'] != '')
                                        <div class="img-div">
                                            <img src="{{get_file_url($data['before_pic'])}}"/>
                                        </div>
                                        @else
                                        <span>暂无修复前图片</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复中</label>
                                <div class="col-sm-3" id="poi_2_box">
                                    @if($data['repairing_pic'] != '')
                                        <div class="img-div">
                                            <img src="{{get_file_url($data['repairing_pic'])}}"/>
                                        </div>
                                    @else
                                        <span>暂无修复中图片</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复后</label>
                                <div class="col-sm-3" id="poi_3_box">
                                    @if($data['after_pic'] != '')
                                        <div class="img-div">
                                            <img src="{{get_file_url($data['after_pic'])}}"/>
                                        </div>
                                    @else
                                        <span>暂无修复后图片</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">档案号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="repair_order_name" value="{{$data['repair_order_name']}}" disabled/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">账目类型</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="name" value="{{\App\Dao\ConstDao::$type_desc[$data['account_type']]}}" disabled/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">藏品信息</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="name" value="{{$data['name']}}" disabled/>
                                    <input type="hidden" class="form-control" id="exhibit_id" value="{{$data['exhibit_sum_register_id']}}" disabled/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">提取日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="pickup_date" name="pickup_date" value="{{$data['pickup_date']}}" disabled/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">归还时间</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="return_date" name="return_date" value="{{$data['return_date']}}" disabled/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">主持人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="host" value="{{$data['host']}}" disabled/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="restorer" value="{{$data['restorer']}}" disabled/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">主任签字</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="header_signature" value="{{$data['header_signature']}}" disabled/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">馆长签字</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="curator_signature" value="{{$data['curator_signature']}}" disabled/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文物现状</label>
                                <div class="col-sm-10">
                                    <textarea name="exhibit_status" class="form-control" cols="60" rows="4" disabled>{{$data['exhibit_status']}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复要求</label>
                                <div class="col-sm-10">
                                    <textarea name="repair_demand" class="form-control" cols="60" rows="4" disabled>{{$data['repair_demand']}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复历史</label>
                                <div class="col-sm-10">
                                    <textarea name="repair_history" class="form-control" cols="60" rows="4" disabled>{{$data['repair_history']}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复方案</label>
                                <div class="col-sm-10">
                                    <textarea name="repair_scheme" class="form-control" cols="60" rows="4" disabled>{{$data['repair_scheme']}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复经过及使用材料</label>
                                <div class="col-sm-10">
                                    <textarea name="process_data" class="form-control" cols="60" rows="4" disabled>{{$data['process_data']}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">检验结果</label>
                                <div class="col-sm-4">
                                    <textarea name="result" class="form-control" cols="60" rows="4" disabled>{{$data['result']}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">方案制定人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="scheme_editor" value="{{$data['scheme_editor']}}" disabled/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">方案审定人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="scheme_checker" value="{{$data['scheme_checker']}}" disabled/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">验收人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="acceptor" value="{{$data['acceptor']}}" disabled/>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a href="{{route('admin.repaireexhibit.repairin.edit',['inside_repair_id'=>$data['inside_repair_id']])}}">
                                        <button class="btn btn-primary" >修改</button>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //藏品详情 显示  绑定藏品信息
        $(function(){
            console.log($('#exhibit_id').val());
            $.ajax('{{route("admin.repaireexhibit.exhibit.detail")}}', {
                method: 'POST',
                data: {'exhibit_id':$('#exhibit_id').val()},
                dataType: 'json'
            }).done(function (response) {
                $('#type_no').val(response.type_no);
                $('#quality').val(response.quality);
                $('#level').val(response.level);
                $('#age').val(response.age);
                $('#size').val(response.size);
                $('#weight').val(response.weight);
            });
        });
    </script>
@endsection
