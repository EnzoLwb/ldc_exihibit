@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.exhibitmanage.instorageroom')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitmanage.instorageroom')}}">修改</a></li>
                        <li><a href="{{route('admin.exhibitmanage.instorageroom')}}">删除</a></li>
                        <li><a href="{{route('admin.exhibitmanage.instorageroom')}}">提交</a></li>
                        <li><a href="{{route('admin.exhibitmanage.instorageroom')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.instorageroom')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitmanage.instorageroom')}}">图文模式</a></li>
                        <li class="active" ><a href="{{route('admin.exhibitmanage.add_instorageroom')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.exhibitcollect.apply_save')}}" class="form-horizontal ajaxForm">
                            <table  class="table" style="margin-left:8%;width:40%">
                                <tbody>

                                <tr ><td colspan="4"><label class="control-label edit-title">登记号</label></td></tr>
                                <tr><td>总登记号</td><td><input type="text" class="form-control" name="id" id="id"
                                                            value="{{$info['id'] or ''}}" required/></td>
                                    <td>入馆凭证号</td><td><input type="text" class="form-control" name="id" id="id"
                                                           value="{{$info['id'] or ''}}" required/></td>
                                </tr>


                                <tr ><td colspan="4"><label class="control-label edit-title">文物详细</label></td></tr>

                                <tr><td>名称</td><td><input type="text" class="form-control" name="id" id="id"
                                                          value="{{$info['id'] or ''}}" required/></td>
                                    <td>数量</td><td><input type="number" class="form-control" name="id" id="id"
                                                          value="{{$info['id'] or ''}}" required/></td>
                                </tr>



                                <tr><td>年代</td><td><input type="text" class="form-control" name="id" id="id"
                                                            value="{{$info['id'] or ''}}" required/></td>
                                    <td>级别</td><td><input type="text" class="form-control" name="id" id="id"
                                                            value="{{$info['id'] or ''}}" required/></td>
                                </tr>
                                <tr><td>尺寸</td><td><input type="text" class="form-control" name="id" id="id"
                                                            value="{{$info['id'] or ''}}" required/></td>
                                    <td >重量</td><td><input type="text" class="form-control" name="id" id="id"
                                                           value="{{$info['id'] or ''}}" required/></td></tr>

                                <tr><td>完残情况</td><td><input type="text" class="form-control" name="id" id="id"
                                                             value="{{$info['id'] or ''}}" required/></td>
                                    <td>分库号</td><td><input type="text" class="form-control" name="id" id="id"
                                                             value="{{$info['id'] or ''}}" required/></td>
                                </tr>

                                <tr><td>备注</td><td colspan="3"><textarea class="form-control"></textarea></td>

                                </tr>
                                <tr ><td colspan="4"><label class="control-label edit-title">入库信息</label></td></tr>

                                <tr><td>入馆日期</td><td><input type="text" class="form-control" name="id" id="id"
                                                          value="{{$info['id'] or ''}}" required/></td>
                                    <td>来源</td><td><input type="number" class="form-control" name="id" id="id"
                                                          value="{{$info['id'] or ''}}" required/></td>
                                </tr>
                                <tr><td>收据号</td><td><input type="text" class="form-control"></td></tr>

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
            file_path: 'squar_list_img',

        });
        $('#poi_4_box').find('.img-div>span').click(function () {
            sUploadDel($(this), 'poi_4')
        });
    </script>
@endsection


