@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">打印</a></li>
                        <li  class="active"><a href="{{route('admin.exhibitmanage.outstorageroom.add_exhibitout')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.exhibitmanage.outstorageroom.exhibitout_save')}}" class="form-horizontal ajaxForm">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">提供部门</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="depart_name" id="depart_name"
                                           value="{{$exhibit_use_info['depart_name'] or ''}}" />
                                </div>
                            </div>
                            <input type="hidden" name="exhibit_use_id" value="{{$exhibit_use_info['exhibit_use_id']}}">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">出库目的</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="outer_destination" id="outer_destination"
                                           value="{{$exhibit_use_info['outer_destination'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">出库日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="outer_time" id="outer_time"
                                           value="{{$exhibit_use_info['outer_time'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房点交人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="outer_sender" id="outer_sender"
                                           value="{{$exhibit_use_info['outer_sender'] or ''}}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">出库目的</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="type">
                                        @foreach(\App\Dao\ConstDao::$exhibit_status_desc as $k=>$v)

                                            <option value="{{$k}}" @if($exhibit_use_info['type'] == $k) selected @endif>{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">提取经手人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="outer_taker" id="outer_taker"
                                           value="{{$exhibit_use_info['outer_taker'] or ''}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="date" id="date"
                                           value="{{$exhibit_use_info['date'] or ''}}" required/>
                                </div>
                            </div>

                            <ul class="nav nav-tabs">
                                <li class="active"><a href="javascript:void(0)">明细</a></li>
                            </ul>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
                                                <thead>
                                                <tr role="row">
                                                    <th>总登记号</th>
                                                    <th>藏品名称</th>

                                                    <th>件数</th>
                                                    <th>级别</th>
                                                    <th>完残情况</th>
                                                    <th>预计归还时间</th>
                                                    <th>备注</th>
                                                </tr>
                                                </thead>
                                                @foreach($exhibit_list as $exhibit)
                                                    <tr class="gradeA">
                                                        <td>{{$exhibit['exhibit_sum_register_num']}}</td>
                                                        <td>{{$exhibit['name']}}</td>

                                                        <td><input type="text" class="form-control"  name="{{$exhibit['exhibit_use_item_id']."_num"}}" value="{{$exhibit['t_num']}}"/></td>
                                                        <td>{{$exhibit['exhibit_level']}} </td>
                                                        <td>{{$exhibit['complete_degree']}} </td>
                                                        <td><input type="text" class="form-control"name="{{$exhibit['exhibit_use_item_id']."_backup_time"}}" value="{{$exhibit['backup_time']}}"/> </td>
                                                        <td><textarea class="form-control" name="{{$exhibit['exhibit_use_item_id']."_backup"}}"> {{$exhibit['t_backup']}} </textarea>   </td>
                                                    </tr>
                                                @endforeach
                                            </table>

                                        </div>
                                    </div>
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
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">添加新的藏品记录</h4>
                </div>
                <div class="modal-body">
                    <table>
                        <tbody>
                            <tr>
                                <td colspan="4"><label class="control-label edit-title"> 登记号</label></td>
                            </tr>
                            <tr><td>总登记号</td><td><input type="text" class="form-control"></td>
                                <td>分类号</td><td><input type="text" class="form-control"></td>
                            </tr>
                            <tr><td>名称</td><td><input type="text" class="form-control"></td>
                                <td>类别</td><td><input type="text" class="form-control"></td>
                            </tr>
                            <tr><td>年代</td><td><input type="text" class="form-control"></td>
                                <td>实际数量</td><td><input type="text" class="form-control"></td>
                            </tr>
                            <tr><td>数量单位</td><td><input type="text" class="form-control"></td>
                                <td>长宽高</td><td><input type="text" class="form-control"></td>
                            </tr>
                            <tr><td>质量</td><td><input type="text" class="form-control"></td>
                                <td>完残情况</td><td><input type="text" class="form-control"></td>
                            </tr>

                            <tr><td>藏品级别</td><td><input type="text" class="form-control"></td>
                                <td>分类单号</td><td><input type="text" class="form-control"></td>
                            </tr>
                            <tr><td>拓片号</td><td><input type="text" class="form-control"></td>
                                <td>附件</td>
                                <td>


                                    <div id="poi_4_picker">选择附件</div>
                                    @if(isset($exhibit) && $exhibit['squar_list_img'] != '')
                                        <div class="img-div">
                                            <img src="{{get_file_url($exhibit['squar_list_img'])}}"/>
                                            <span class="cancel">×</span>
                                        </div>
                                    @endif

                                </td>
                            </tr>
                        </tbody>
                    </table>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary">提交更改</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>


    <script src="{{cdn('js/plugins/webuploader/webuploader.nolog.min.js')}}"></script>
    <script src="{{cdn('js/plugins/webuploader/webuploader_public.js')}}"></script>
    <script>
        function show_item() {
            $("#myModal").modal();
        }
    </script>
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


