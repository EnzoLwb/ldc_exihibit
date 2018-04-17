@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.exhibitlogout')}}">藏品注销</a></li>
                        <li @if(!isset($data))class="active"@endif><a href="{{route('admin.exhibitlogout.add')}}">新增</a></li>
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
                        <form action="{{route('admin.exhibitlogout.save')}}" method="post" class="form-horizontal ajaxForm">
                            <input type="hidden" name="logout_id" value="{{$data['logout_id']??''}}">
                            <input type="hidden" value="{{csrf_token()}}" name="_token">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">选择账目类型</label>
                                <div class="col-sm-4">
                                    <select name="account_type" id="account_type" class="form-control">
                                        @foreach(\App\Dao\ConstDao::$type_desc as $k=>$v)
                                            <option value="{{$k}}"
                                                    @if(isset($data)&&$k == $data['account_type']) selected @endif
                                            >{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">藏品名称</label>
                                <div class="col-sm-4">
                                    <select name="exhibit_sum_register_id" id="exhibit_sum_register_id" class="form-control">
                                        @foreach($exhibits as $v)
                                            @if(@$data['name']==$v['name']||old('exhibit_id')==$v['name'])
                                                <option value="{{$v['id']}}" selected="selected">{{$v['name']}}</option>
                                            @else
                                                <option value="{{$v['id']}}">{{$v['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">注销凭证号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="logout_num" value="{{$data['logout_num']??old('logout_num')}}"/>
                                </div>
                                @if ($errors->has('logout_num'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('logout_num') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">注销凭证名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="logout_name" value="{{$data['logout_name']??old('logout_name')}}"/>
                                </div>
                                @if ($errors->has('logout_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('logout_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">注销日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="logout_date" name="logout_date" value="{{$data['logout_date']??old('logout_date')}}"/>
                                </div>
                                @if ($errors->has('logout_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('logout_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">注销批准文号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="logout_pizhun_num" value="{{$data['logout_pizhun_num']??old('logout_pizhun_num')}}"/>
                                </div>
                                @if ($errors->has('logout_pizhun_num'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('logout_pizhun_num') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">注销原因</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="logout_reason" value="{{$data['logout_reason']??old('logout_reason')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">详情描述</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="logout_desc" value="{{$data['logout_desc']??old('logout_desc')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">登记人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="register" value="{{$data['register']??old('register')}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">登记日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="register_date" name="register_date" value="{{$data['register_date']??old('register_date')}}"/>
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
@endsection
@section('script')
    <script type="text/javascript" src="{{cdn('js/plugins/laydate_new/laydate.js')}}"></script>
    <script type="text/javascript">
        //入库时间设置
        var register_date = laydate.render({
            elem: '#register_date',
            type: 'datetime',
            min: '1999-1-1 00:00:00',
            max: '2099-6-16 23:59:59',
        });
        var logout_date = laydate.render({
            elem: '#logout_date',
            type: 'datetime',
            min: '1999-1-1 00:00:00',
            max: '2099-6-16 23:59:59',
        });
        $('#account_type').change(function () {
            //改变藏品的类型后改变下面的藏品名称  辅助账或者总账
            $.ajax('{{route("admin.accountmanage.item_list")}}', {
                method: 'get',
                data: {'type': $("#account_type").val()},
                dataType: 'json'
            }).done(function (response) {
                len = response.data.length
                $("#exhibit_sum_register_id").html('');
                for (i=0;i<len;i++){
                    $("#exhibit_sum_register_id").append("<option value='"+response.data[i].register_id+"'>"+response.data[i].name+"</option>");
                }
            });
        })
    </script>
@endsection