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
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">修改</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">删除</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">提交</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">图文模式</a></li>
                        <li  class="active"><a href="{{route('admin.exhibitmanage.outstorageroom.add_exhibitout')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.exhibitcollect.apply_save')}}" class="form-horizontal ajaxForm">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">提供部门</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="id" id="id"
                                           value="{{$info['id'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">出库目的</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="id" id="id"
                                           value="{{$info['id'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">出库日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="id" id="id"
                                           value="{{$info['id'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房点交人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="id" id="id"
                                           value="{{$info['id'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">提取经手人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="id" id="id"
                                           value="{{$info['id'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="id" id="id"
                                           value="{{$info['id'] or ''}}" required/>
                                </div>
                            </div>
                            <ul class="nav nav-tabs">
                                <li ><a href="javascript:void(0)" onclick="show_item()">新增</a></li>
                                <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">修改</a></li>
                                <li><a href="{{route('admin.exhibitmanage.outstorageroom.exhibitout')}}">删除</a></li>
                                <li ><a href="{{route('admin.exhibitmanage.outstorageroom.add_exhibitout')}}">新增</a></li>
                            </ul>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
                                                <thead>
                                                <tr role="row">
                                                    <th>选择</th>
                                                    <th>总登记号</th>
                                                    <th>藏品名称</th>
                                                    <th>出库类型</th>
                                                    <th>件数</th>
                                                    <th>级别</th>
                                                    <th>完残情况</th>
                                                    <th>预计归还时间</th>
                                                    <th>备注</th>
                                                </tr>
                                                </thead>
                                                @foreach($exhibit_list as $exhibit)
                                                    <tr class="gradeA">
                                                        <td><input type="radio"></td>
                                                        <td>{{$exhibit['num']}}</td>
                                                        <td>{{$exhibit['depart_name']}}</td>
                                                        <td>{{$exhibit['depart_object']}}</td>
                                                        <td>{{$exhibit['depart_project_name']}} </td>
                                                        <td>{{$exhibit['apply_depart']}} </td>
                                                        <td>{{$exhibit['apply_money']}} </td>
                                                        <td>{{$exhibit['apply_count']}} </td>
                                                        <td>{{$exhibit['applyer']}} </td>
                                                        <td>{{$exhibit['project_desc']}} </td>
                                                        <td>{{$exhibit['project_reason']}} </td>
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
                    <div class="form-group">
                        <label class="col-sm-2 control-label">总登记号</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="rssii" name="rssii"
                                   value="{{$info['rssii'] or ''}}" required/>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">分类号</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="rssii" name="rssii"
                                   value="{{$info['rssii'] or ''}}" required/>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">名称</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="rssii" name="rssii"
                                   value="{{$info['rssii'] or ''}}" required/>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">类别</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="rssii" name="rssii"
                                   value="{{$info['rssii'] or ''}}" required/>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">年代</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="rssii" name="rssii"
                                   value="{{$info['rssii'] or ''}}" required/>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">实际数量</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="rssii" name="rssii"
                                   value="{{$info['rssii'] or ''}}" required/>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">数量单位</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="rssii" name="rssii"
                                   value="{{$info['rssii'] or ''}}" required/>
                        </div>
                    </div>
                    <br>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">长宽高</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="rssii" name="rssii"
                                       value="{{$info['rssii'] or ''}}" required/>
                            </div>
                        </div>


                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">质量</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="rssii" name="rssii"
                                   value="{{$info['rssii'] or ''}}" required/>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">完残情况</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="rssii" name="rssii"
                                   value="{{$info['rssii'] or ''}}" required/>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">藏品级别</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="rssii" name="rssii"
                                   value="{{$info['rssii'] or ''}}" required/>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">分类单号</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="rssii" name="rssii"
                                   value="{{$info['rssii'] or ''}}" required/>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">拓片号</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="rssii" name="rssii"
                                   value="{{$info['rssii'] or ''}}" required/>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">附件</label>
                        <div class="col-sm-10" id="poi_4_box">

                            <div id="poi_4_picker">选择附件</div>
                            @if(isset($exhibit) && $exhibit['squar_list_img'] != '')
                                <div class="img-div">
                                    <img src="{{get_file_url($exhibit['squar_list_img'])}}"/>
                                    <span class="cancel">×</span>
                                </div>
                            @endif
                        </div>
                        <input type="hidden" id="squar_list_img" name="squar_list_img" value="{{$exhibit['squar_list_img']  or ''}}"/>
                    </div>
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


