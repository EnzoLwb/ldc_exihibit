@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">
@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.exhibitcollect.getin')}}">查询</a></li>
                        <li class="active"><a href="{{route('admin.exhibitcollect.getin_add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form1 method="post" action="{{route('admin.exhibitcollect.getin_save')}}" class="form-horizontal ajaxForm">

                            <input type="hidden" name="collect_recipe_id" id="collect_recipe_id"
                                   value="{{$info['collect_recipe_id'] or 0}}" />

                            <div class="form-group">
                                <label class="col-sm-2 control-label">入馆凭证号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="collect_recipe_num" id="collect_recipe_num"
                                           value="{{$info['collect_recipe_num'] or ''}}" required/>
                                    <input type="hidden" name="_token"
                                           value="{{csrf_token()}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">入馆凭证名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="collect_recipe_name" id="collect_recipe_name"
                                           value="{{$info['collect_recipe_name'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">入馆日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="collect_date"  name="collect_date"
                                           value="{{$info['collect_date'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">收据号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="recipe_num" name="recipe_num"
                                           value="{{$info['recipe_num'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">备注</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" name="mark" id="mark">{{$info['mark']}}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">入馆方式</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="collect_apply_id" id="collect_apply_id">
                                        @if($info['collect_apply_id'] == \App\Dao\ConstDao::EXHIBIT_COLLECT_RECIPE_SRC_BY_DIRECT)
                                            <option  selected value="{{\App\Dao\ConstDao::EXHIBIT_COLLECT_RECIPE_SRC_BY_DIRECT}}">直接入馆</option>
                                        @else
                                            <option   value="{{\App\Dao\ConstDao::EXHIBIT_COLLECT_RECIPE_SRC_BY_DIRECT}}">直接入馆</option>
                                        @endif
                                        @foreach($apply_list as $item)
                                            @if($info['collect_apply_id'] == $item['collect_apply_id'])
                                                <option selected value="{{$item['collect_apply_id']}}">{{$item['collect_apply_project_name']}}</option>
                                            @else
                                                    <option  value="{{$item['collect_apply_id']}}">{{$item['collect_apply_project_name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row m-b">
                                <div class="col-sm-12">
                                    <div class="tabs-container">
                                        <ul class="nav nav-tabs">
                                            <li ><a href="javascript:void(0)" onclick="show_item()">新增</a></li>
                                            <li><a href="{{route('admin.exhibitcollect.getin_add')}}">修改</a></li>
                                            <li><a href="{{route('admin.exhibitcollect.getin_add')}}">删除</a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
                                                <thead>
                                                <tr role="row">
                                                    <th>总登记号</th>
                                                    <th>分类号</th>
                                                    <th>名称</th>
                                                    <th>类别</th>
                                                    <th>年代</th>
                                                    <th>实际数量</th>
                                                    <th>实际数量单位</th>
                                                    <th>长宽高</th>
                                                    <th>质量</th>
                                                    <th>完残情况</th>
                                                    <th>藏品级别</th>
                                                    <th>分类单号</th>
                                                    <th>拓片号</th>
                                                    <th>底板号</th>
                                                    <th>附件</th>
                                                </tr>
                                                </thead>
                                                <tbody id="content_list">
                                                @foreach($collect_exhibit_list as $exhibit)
                                                    <tr class="gradeA" id="{{$exhibit->exhibit_sum_register_num}}">
                                                        <td>{{$exhibit->exhibit_sum_register_num}}</td>
                                                        <td>{{$exhibit->type_num}}</td>
                                                        <td>{{$exhibit->name}}</td>
                                                        <td>{{$exhibit->type}}</td>
                                                        <td>{{$exhibit->age}}</td>
                                                        <td>{{$exhibit->num}}</td>
                                                        <td>{{$exhibit->num_unit}}</td>
                                                        <td>{{$exhibit->lwh}}</td>
                                                        <td>{{$exhibit->quality}}</td>
                                                        <td>{{$exhibit->complete_degree}}</td>
                                                        <td>{{$exhibit->exhibit_level}}</td>
                                                        <td>{{$exhibit->type_order_num}}</td>
                                                        <td>{{$exhibit->rubbing_num}}</td>
                                                        <td>{{$exhibit->baseboard_num}}</td>
                                                        <td>{{$exhibit->files}}</td>
                                                    </tr>
                                                </tbody>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    @if($operation != \App\Dao\ConstDao::OPERATION_VIEW)
                                        <button class="btn btn-primary" type="submit1" onclick="submit_all_content()">保存</button>
                                    @endif
                                    <button class="btn btn-white" type="button" onclick="window.history.back()">返回
                                    </button>
                                </div>
                            </div>
                        </form1>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- 模态框（Modal） -->
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
                            <input type="text" class="form-control" id="exhibit_sum_register_num" name="exhibit_sum_register_num"   />
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">分类号</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="type_num" name="type_num"
                                   value="" />
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">名称</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="name" name="name"
                                   value="" />
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">类别</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="type" name="type"
                                   value="" />
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">年代</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="age" name="age"
                                   value="" />
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">实际数量</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="num" name="num"
                                   value="" />
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">数量单位</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="common_num_uint" name="common_num_uint"
                                   value="" />
                        </div>
                    </div>
                    <br>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">长宽高</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="lwh" name="lwh"
                                   value="" />
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">质量</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="quality" name="quality"
                                   value="" />
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">完残情况</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="complete_degree" name="complete_degree"
                                   value="" />
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">藏品级别</label>
                        <div class="col-sm-4">
                            <select name="exhibit_level" id="exhibit_level" name="exhibit_level" class="form-control">
                                @foreach(\App\Dao\ConstDao::$exhibit_level_desc as $k=>$item)
                                    <option value="{{$k}}"
                                            @if($item == $info['exhibit_level']) selected @endif
                                    >
                                        {{$item}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">分类单号</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="type_order_num" name="type_order_num"
                                   value="" />
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">拓片号</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="rubbing_num" name="rubbing_num"
                                   value="" />
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">底板号</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="baseboard_num" name="baseboard_num"
                                   value="" />
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">附件</label>
                        <div class="col-sm-10" id="poi_4_box">
<style>
#poi_4_picker .webuploader-pick+div{ width: 80px !important; height: 32px !important;}
</style>
                            <div id="poi_4_picker">选择附件</div>
                            @if(isset($exhibit) && $exhibit['squar_list_img'] != '')
                                <div class="img-div">
                                    <img src="{{get_file_url($exhibit['squar_list_img'])}}"/>
                                    <span class="cancel">×</span>
                                </div>
                            @endif
                        </div>
                        <input type="hidden" id="files" name="files" value="{{$exhibit['squar_list_img']  or ''}}"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" onclick="submit_item()">提交更改</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
    <script src="{{cdn('js/plugins/webuploader/webuploader.nolog.min.js')}}"></script>
    <script src="{{cdn('js/plugins/webuploader/webuploader_public.js')}}"></script>
    <script>

        //将所有的内容进行提交
        function submit_all_content() {
            data={}
            data['collect_recipe_id'] = $("#collect_recipe_id").val()
            data['collect_recipe_num'] = $("#collect_recipe_num").val()
            data['collect_recipe_name'] = $("#collect_recipe_name").val()
            data['collect_date'] = $("#collect_date").val()
            data['recipe_num'] = $("#recipe_num").val()
            data['collect_apply_id'] = $("#collect_apply_id").val()
            data['mark'] = $("#mark").val()
            data['_token'] = "{{csrf_token()}}"
            header = []
            header[0] = 'exhibit_sum_register_num';
            header[1] = 'type_num';
            header[2] = 'name';
            header[3] = 'type';
            header[4] = 'age';
            header[5] = 'num';
            header[6] = 'num_uint';
            header[7] = 'lwh';
            header[8] = 'quality';
            header[9] = 'complete_degree';
            header[10] = 'exhibit_level';
            header[11] = 'type_order_num';
            header[12] = 'rubbing_num';
            header[13] = 'baseboard_num';
            header[14] = 'files';
            colnums = 14;
            item_length = $("#content_list").find('tr').length
            list_data  = [];
            for(i=0;i<item_length;i++){
                item = {}
                for(j=0;j<=colnums;j++){
                    current_header = header[j]
                    item[current_header] =$($($("#content_list").find('tr')[i]).find('td')[j]).html()
                }
                list_data.push(item)
            }
            data['list'] = list_data;
            $.ajax('{{route("admin.exhibitcollect.getin_save")}}', {
                method: 'POST',
                data: data,
                dataType: 'json'
            }).done(function (response) {
                layer.alert(response.msg)
                setTimeout("location.reload();", 3000)
            });
        }
        //添加入馆明细
        function submit_item() {
            sum_register_num = $("#exhibit_sum_register_num").val();
            type_num = $("#type_num").val();
            exhibit_name = $("#name").val();
            type = $("#type").val();
            age = $("#age").val();
            common_num_uint = $("#common_num_uint").val();
            num = $("#num").val();
            lwh = $("#lwh").val();
            quality = $("#quality").val();
            complete_degree = $("#complete_degree").val();
            exhibit_level = $("#exhibit_level").val();
            type_order_num = $("#type_order_num").val();
            rubbing_num = $("#rubbing_num").val();
            baseboard_num = $("#baseboard_num").val();
            files = $("#files").val();
            //开始修改
            str_id = "#" + sum_register_num.toString();
                //新加内容
                tr_str = "<tr id='"+sum_register_num+"'>"
                tr_str += "<td>"+sum_register_num+ "</td>"
                tr_str += "<td>"+type_num+ "</td>"
                tr_str += "<td>"+exhibit_name+ "</td>"
                tr_str += "<td>"+type+ "</td>"
                tr_str += "<td>"+age+ "</td>"
                tr_str += "<td>"+num+ "</td>"
                tr_str += "<td>"+common_num_uint+ "</td>"
                tr_str += "<td>"+lwh+ "</td>"
                tr_str += "<td>"+quality+ "</td>"
                tr_str += "<td>"+complete_degree+ "</td>"
                tr_str += "<td>"+exhibit_level+ "</td>"
                tr_str += "<td>"+type_order_num+ "</td>"
                tr_str += "<td>"+rubbing_num+ "</td>"
                tr_str += "<td>"+baseboard_num+ "</td>"
                tr_str += "<td>"+files+ "</td>"
                tr_str += "</tr>";
                $("#content_list").append(tr_str);
            $("#myModal").modal('hide')
        }

        //方形列表图
        singleUpload({
            _token: '{{csrf_token()}}',
            type_key: 'FT_ONE_RESOURCE',
            item_id: '{{$exhibit['exhibit_id'] or 0}}',
            pick: 'poi_4_picker',
            boxid: 'poi_4_box',
            file_path: 'files',
        });
        $('#poi_4_box').find('.img-div>span').click(function () {
            sUploadDel($(this), 'poi_4')
        });

        //清空明细内容
        function clear_item_input() {
            $("#sum_register_id").val('');
            $("#type_num").val('');
            $("#name").val('');
            $("#type").val('');
            $("#age").val('');
            $("#common_num_uint").val('');
            $("#lwh").val('');
            $("#quality").val('');
            $("#complete_degree").val('');
            $("#exhibit_level").val('');
            $("#type_order_num").val('');
            $("#rubbing_num").val('');
        }
        //新加内容
        function show_item() {
            clear_item_input();
            $("#myModal").modal();
        }
    </script>
@endsection





