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
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.exhibitcollect.apply_save')}}" class="form-horizontal ajaxForm">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">总登记号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="id" id="id"
                                           value="{{$info['id'] or ''}}" required/>
                                    <input type="hidden" name="_token"
                                           value="{{csrf_token()}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">原编号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="minor" id="minor"
                                           value="{{$info['minor'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">曾用号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="major"  name="major"
                                           value="{{$info['major'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">入馆凭证号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="rssia" name="rssia"
                                           value="{{$info['rssia'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">现用名</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="rssii" name="rssii"
                                           value="{{$info['rssii'] or ''}}" required/>
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="col-sm-2 control-label">曾用名</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">年代类型</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">具体年代</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">历史阶段</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">质地类型1</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">质地类型2</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">普查质地</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">具体质地</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">类别范围</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">具体类别</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">传统数量</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">传统数量单位</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">实际数量</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">传统数量单位</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">具体质量</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">质量范围</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">尺寸</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">长宽高</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">来源方式</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">具体来源</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">来源补充</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">完残程度</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">完残状况</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">入藏具体时间</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">入藏年代</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">入藏时间范围</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">具体存放地点</label>
                                <div class="col-sm-4">
                                    <select class="form-control">
                                        <option>本馆</option>
                                        <option>借展</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">原展厅具体位置</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">展厅柜号</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">藏品性质</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">注销凭证号</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">藏品状态</label>
                                <div class="col-sm-4">
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
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">备注</label>
                                <div class="col-sm-4">
                                    <input type="textarea" class="form-control" rows="2" cols="20" id="distancei" name="distancei"
                                           value="{{$info['distancei'] or ''}}" required/>
                                </div>
                            </div>
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


