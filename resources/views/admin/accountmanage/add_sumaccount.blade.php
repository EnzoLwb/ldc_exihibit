@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.accountmanage.sumaccount')}}">查询</a></li>

                        <li><a href="{{route('admin.accountmanage.sumaccount')}}">总账复核</a></li>
                        <li><a href="{{route('admin.accountmanage.sumaccount')}}">送鉴定</a></li>
                        <li><a href="{{route('admin.accountmanage.sumaccount')}}">导出</a></li>
                        <li><a href="{{route('admin.accountmanage.sumaccount')}}">打印</a></li>
                        <li><a href="{{route('admin.accountmanage.sumaccount')}}">图文模式</a></li>
                        <li class="active" ><a href="{{route('admin.accountmanage.add_sumaccount')}}">修改</a></li>
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
                            <tr><td>曾用号</td><td><input type="text" class="form-control" name="id" id="id"
                                                       value="{{$info['id'] or ''}}" required/></td>
                                <td>入馆凭证</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                            </tr>

                            <tr ><td colspan="4"><label class="control-label edit-title">文物名称</label></td></tr>

                            <tr><td>现用名</td><td><input type="text" class="form-control" name="id" id="id"
                                                       value="{{$info['id'] or ''}}" required/></td>
                                <td>曾用名</td><td><input type="text" class="form-control" name="id" id="id"
                                                       value="{{$info['id'] or ''}}" required/></td>
                            </tr>

                            <tr ><td colspan="4"><label class="control-label edit-title">年代</label></td></tr>

                            <tr><td>年代类型</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                                <td>具体年代</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                            </tr>
                            <tr><td>历史阶段</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                            </tr>
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

                            <tr ><td colspan="4"><label class="control-label edit-title">文物类别</label></td></tr>

                            <tr><td>类别范围</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                                <td>具体类别</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                            </tr>

                            <tr ><td colspan="4"><label class="control-label edit-title">数量</label></td></tr>

                            <tr><td>传统数量</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                                <td>传统数量单位</td><td><input type="text" class="form-control" name="id" id="id"
                                                          value="{{$info['id'] or ''}}" required/></td>
                            </tr>
                            <tr><td>实际数量</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                                <td>实际数量单位</td><td><input type="text" class="form-control" name="id" id="id"
                                                          value="{{$info['id'] or ''}}" required/></td>
                            </tr>
                            <tr ><td colspan="4"><label class="control-label edit-title">质量</label></td></tr>

                            <tr><td>具体质量</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                                <td>质量范围</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                            </tr>

                            <tr ><td colspan="4"><label class="control-label edit-title">外形</label></td></tr>

                            <tr><td>尺寸</td><td><input type="text" class="form-control" name="id" id="id"
                                                      value="{{$info['id'] or ''}}" required/></td>
                                <td>长宽高</td><td><input type="text" class="form-control" name="id" id="id"
                                                       value="{{$info['id'] or ''}}" required/></td>
                            </tr>

                            <tr><td >文物级别</td><td ><input type="text" class="form-control" name="id" id="id"
                                                          value="{{$info['id'] or ''}}" required/></td>
                            </tr>
                            <tr ><td colspan="4"><label class="control-label edit-title">来源</label></td></tr>

                            <tr><td>来源方式</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                                <td>具体来源</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                            </tr>

                            <tr><td>来源补充</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td></tr>

                            <tr ><td colspan="4"><label class="control-label edit-title">完残</label></td></tr>

                            <tr><td>完残程度</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                                <td>完残状况</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                            </tr>
                            <tr><td>保存状态</td><td ><input type="text" class="form-control" name="id" id="id"
                                                         value="{{$info['id'] or ''}}" required/></td></tr>
                            <tr ><td colspan="4"><label class="control-label edit-title">入馆时间</label></td></tr>
                            <tr><td>入藏具体时间</td><td ><input type="text" class="form-control" name="id" id="id"
                                                           value="{{$info['id'] or ''}}" required/></td>
                                <td>入藏年代</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                            </tr>
                            <tr><td>入藏时间范围</td><td ><input type="text" class="form-control" name="id" id="id"
                                                           value="{{$info['id'] or ''}}" required/></td></tr>
                            <tr ><td colspan="4"><label class="control-label edit-title">其他信息</label></td></tr>
                            <tr><td>具体存放地点</td><td><input type="text" class="form-control" name="id" id="id"
                                                          value="{{$info['id'] or ''}}" required/></td>
                            </tr>

                            <tr><td>原展厅具体位置</td><td><input type="text" class="form-control" name="id" id="id"
                                                           value="{{$info['id'] or ''}}" required/></td>
                            </tr>
                            <tr><td>展厅柜号</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                            </tr>
                            <tr><td>藏品性质</td><td><input type="text" class="form-control" name="id" id="id"
                                                        value="{{$info['id'] or ''}}" required/></td>
                            </tr>

                            <tr><td>注销凭证号</td><td><input type="text" class="form-control" name="id" id="id"
                                                         value="{{$info['id'] or ''}}" required/></td>
                            </tr>
                            <tr><td>藏品状态</td><td>
                                    <select class="form-control">
                                        <option>拨交</option>
                                        <option>观摩</option>
                                        <option>复制</option>
                                        <option>拍卖</option>
                                        <option>交换</option>
                                        <option>捐赠</option>
                                        <option>丢失</option>
                                        <option>报损</option>
                                        <option>借出</option>
                                        <option>展出</option>
                                        <option>注销</option>
                                    </select>

                                </td>
                            </tr>

                            <tr><td>备注</td><td colspan="3">
                                    <textarea class="form-control"></textarea>

                                </td>
                            </tr>
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


