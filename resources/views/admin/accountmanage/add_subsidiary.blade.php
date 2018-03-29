@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.accountmanage.subsidiary')}}">查询</a></li>

                        <li><a href="{{route('admin.accountmanage.subsidiary')}}">浏览</a></li>
                        <li><a href="{{route('admin.accountmanage.subsidiary')}}">注销</a></li>
                        <li><a href="{{route('admin.accountmanage.subsidiary')}}">导出</a></li>
                        <li><a href="{{route('admin.accountmanage.subsidiary')}}">打印</a></li>
                        <li><a href="{{route('admin.accountmanage.subsidiary')}}">图文模式</a></li>
                        <li  class="active"><a href="{{route('admin.accountmanage.add_subsidiary')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <td class="col-sm-12">
            <td class="ibox float-e-margins">
                <tr class="ibox-content">
                    <form method="post" action="{{route('admin.exhibitcollect.apply_save')}}" class="form-horizontal ajaxForm">

                        <table  class="table" style="margin-left:8%;width:40%">
                            <tbody>
                            <tr>
                                <td>收藏单位</td>
                                <td colspan="3">
                                    <input type="text" class="form-control" name="id" id="id"
                                           value="{{$info['id'] or ''}}" required/>
                                    <input type="hidden" name="_token"
                                           value="{{csrf_token()}}" />
                                </td>
                            </tr>
                            <tr>
                                <td>附件</td>
                                <td colspan="3">

                                    <div id="poi_4_picker">选择附件</div>
                                    @if(isset($exhibit) && $exhibit['squar_list_img'] != '')
                                        <div class="img-div">
                                            <img src="{{get_file_url($exhibit['squar_list_img'])}}"/>
                                            <span class="cancel">×</span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr ><td colspan="4"><label class="control-label edit-title">登记号</label></td></tr>
                            <tr><td>总登记号</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                                <td>原编号</td><td><input type="text" class="form-control" name="id" id="id"
                                                       value="{{$info['id'] or ''}}" required/></td>
                            </tr>
                            <tr><td>分类号</td><td><input type="text" class="form-control" name="id" id="id"
                                                       value="{{$info['id'] or ''}}" required/></td>
                                <td>入馆登记号</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                            </tr>

                            <tr ><td colspan="4"><label class="control-label edit-title">文物名称</label></td></tr>

                            <tr><td>名称</td><td><input type="text" class="form-control" name="id" id="id"
                                                       value="{{$info['id'] or ''}}" required/></td>
                                <td>原名</td><td><input type="text" class="form-control" name="id" id="id"
                                                       value="{{$info['id'] or ''}}" required/></td>
                            </tr>

                            <tr ><td colspan="4"><label class="control-label edit-title">年代</label></td></tr>

                            <tr><td>年代类型</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                                <td>具体年代</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                            </tr>
                            <tr><td>历史阶段</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td></tr>

                            <tr ><td colspan="4"><label class="control-label edit-title">质地</label></td></tr>

                            <tr><td>质地类型1</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                                <td>质地类型2</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                            </tr>
                            <tr><td>普查质地</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                                <td>具体质地</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                            </tr>
                            <tr><td>类别范围</td><td><input type="text" class="form-control" name="id" id="id"
                                                         value="{{$info['id'] or ''}}" required/></td></tr>
                            <tr><td>类型</td><td>
                                    <select class="form-control">
                                        <option>未定级文物登记账</option>
                                        <option>复制品登记账</option>
                                        <option>仿制品登记账</option>
                                        <option>资料登记账</option>
                                        <option>借入文物登记账</option>
                                        <option>代管文物登记账</option>
                                        <option>外借文物登记账</option>
                                    </select>
                                </td></tr>
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


