@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.repaireexhibit.apply')}}">修复申请</a></li>
                        <li @if(!isset($data))class="active"@endif><a href="{{route('admin.repaireexhibit.apply.add')}}">新增</a></li>
                        @if(isset($data))
                            <li class="active"><a href="#">编辑</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="{{route('admin.repaireexhibit.apply.save')}}" method="post" class="form-horizontal">
                            <input type="hidden" name="repair_id" value="{{$data['repair_id']??''}}">
                            <input type="hidden" value="{{csrf_token()}}" name="_token">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复申请单号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="repair_order_no" value="{{$data['repair_order_no']??old('repair_order_no')}}"/>
                                </div>
                                @if ($errors->has('repair_order_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('repair_order_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复申请单名称</label>
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
                                <label class="col-sm-2 control-label">经费预算</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="plan_expense" value="{{$data['plan_expense']??old('plan_expense')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">登记人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="register_member" value="{{$data['register_member']??old('register_member')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">登记日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="register_date" id="register_date" value="{{$data['register_date']??old('register_date')}}"/>
                                </div>
                            </div>
                            <input type="hidden" name="exhibit_sum_register_id" id="exhibit_sum_register_ids" value="">
                            <input type="hidden" name="subsidiary_id" id="subsidiary_ids" value="">
                            <div>
                                <div class="row">
                                    <label class="col-sm-2 control-label">从以下列表中选择藏品(至少一件)</label>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-sm-5">
                                    <iframe class="J_iframe" name="rIframe" id="rIframe" width="100%" style="height: 200px;" frameborder="0" src="{{route('admin.exhibitidentify.get_exhibit_list')}}"></iframe>
                                </div>
                                <div class="col-sm-5">
                                    <iframe class="J_iframe" name="rIframe" id="rIframe" width="100%" style="height: 200px;" frameborder="0" src="{{route('admin.exhibitidentify.get_subsidiary_list')}}"></iframe>
                                </div>
                            </div>

                            <div class="form-group" >
                                <div class="col-sm-6 col-sm-offset-4" style="margin-top: 80px">
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
@endsection
@section('script')
    <script type="text/javascript" src="{{cdn('js/plugins/laydate_new/laydate.js')}}"></script>
    <script type="text/javascript">
        function test() {
            select_exhibit_ids = [];
            input_length = $($(window.frames["rIframe"].document).find("input")).length
            for(i=0;i<input_length;i++){
                if($($($(window.frames["rIframe"].document).find("input"))[i]).is(':checked')){
                    select_exhibit_ids.push($($($(window.frames["rIframe"].document).find("input"))[i]).val())
                }
            }
        }
        //入库时间设置
        var register_date = laydate.render({
            elem: '#register_date',
            type: 'datetime',
            min: '1999-1-1 00:00:00',
            max: '2099-6-16 23:59:59',
        });
    </script>
@endsection