@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.exhibitidentify.expert')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitidentify.expert')}}">启用</a></li>
                        <li><a href="{{route('admin.exhibitidentify.expert')}}">禁用</a></li>
                        <li  class="active"><a href="{{route('admin.exhibitidentify.expert_add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.exhibitidentify.expert_save')}}" class="form-horizontal ajaxForm">

                            <input type="hidden" class="form-control" name="uid" id="uid"
                                   value="{{$info['uid'] or ''}}" required/>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">姓名</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="username" id="username"
                                           value="{{$info['username'] or ''}}" required/>
                                    <input type="hidden" name="_token"
                                           value="{{csrf_token()}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" name="password" id="password"
                                           value="{{$info['password'] or ''}}" required/>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">职务</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="duties" id="duties"
                                           value="{{$info['duties'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">性别</label>
                                <div class="col-sm-4">
                                   <select class="form-control" name="sex">
                                       <option VALUE="1"
                                               @if(isset($info['sex'])&& $info['sex'] == 1)
                                                   selected
                                               @endif
                                       >男</option>
                                       <option value="0"
                                               @if(isset($info['sex'])&&$info['sex'] == 0)
                                               selected
                                               @endif>女</option>
                                   </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">状态</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="status">
                                        <option value = "{{\App\Dao\ConstDao::EXPERT_STATUS_USING}}"
                                                @if(isset($info['status'])&&$info['status'] == \App\Dao\ConstDao::EXPERT_STATUS_USING)
                                                    selected
                                                @endif
                                        >启用</option>
                                        <option value="{{\App\Dao\ConstDao::EXPERT_STATUS_BLACKLIST}}"
                                                @if(isset($info['status'])&&$info['status'] == \App\Dao\ConstDao::EXPERT_STATUS_BLACKLIST)
                                                selected
                                                @endif
                                        >停用</option>
                                    </select>
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="col-sm-2 control-label">职称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="job_title" name="job_title"
                                           value="{{$info['job_title'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">所属部门</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="depart" name="depart"
                                           value="{{$info['depart'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">鉴定成果</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="identify_result" name="identify_result"
                                           value="{{$info['identify_result'] or ''}}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">业务专长</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="profession_skills" name="profession_skills"
                                           value="{{$info['profession_skills'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">联系方式（手机）</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="phone" name="phone"
                                           value="{{$info['phone'] or ''}}" />
                                </div>
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


