@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.exhibitshow.apply')}}">展览申请</a></li>
                        <li @if(!isset($data))class="active"@endif><a href="{{route('admin.exhibitshow.apply.add')}}">新增</a></li>
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
                        <form action="{{route('admin.exhibitshow.apply.save')}}" method="post" class="form-horizontal">
                            <input type="hidden" class="form-control" name="show_apply_id" value="{{$info['show_apply_id'] or ''}}"/>
                            <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}"/>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">申请人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="applyer" value="{{$info['applyer'] or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">申请时间</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="apply_time" value="{{$info['apply_time'] or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">展览主题</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="theme" value="{{$info['theme'] or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">参展人员</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="exhibitor" value="{{$info['exhibitor'] or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">展览编号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="show_num" value="{{$info['show_num'] or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">开始时间</label>
                                <div class="col-sm-4">
                                    <input placeholder="开始日期" class="form-control layer-date laydate-icon" id="start_date" type="text" name="start_date"
                                           value="{{$info['start_date'] or ''}}"
                                           style="width: 140px;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">结束时间</label>
                                <div class="col-sm-4">
                                    <input placeholder="开始日期" class="form-control layer-date laydate-icon" id="end_date" type="text" name="end_date"
                                           value="{{$info['end_date'] or ''}}"
                                           style="width: 140px;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">展位选择</label>
                                <div class="col-sm-8 exhibit_list">
                                    @foreach($pos_list as $kk=>$gg)
                                        <div class="exhibit_box">
                                            {{$gg['name']}}&nbsp;&nbsp;
                                            <input type="checkbox" name="show_position_id[]" value="{{$gg['show_position_id']}}"
                                                   @if($gg['show_apply_id'] == $show_apply_id)checked @endif /><br>
                                        </div>
                                    @endforeach
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
    <script src="{{cdn('js/public.js')}}"></script>
    <script type="text/javascript" src="{{cdn('js/plugins/laydate/laydate.js')}}"></script>
    <script>
        var start = $.extend({}, laydateOptions, {
            elem: "#start_date",
            choose: function (datas) {
            }
        });
        var end = $.extend({}, laydateOptions, {
            elem: "#end_date",
            choose: function (datas) {
            }
        });
        laydate(start);
        laydate(end);
    </script>
@endsection
