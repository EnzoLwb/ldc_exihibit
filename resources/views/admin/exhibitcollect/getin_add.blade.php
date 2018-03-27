@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.exhibitcollect.getin')}}">查询</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">修改</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">删除</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">提交</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">送鉴定</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">导出</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">打印</a></li>
                        <li><a href="{{route('admin.exhibitcollect.getin')}}">图文模式</a></li>
                        <li class="active"><a href="{{route('admin.exhibitcollect.getin_add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form method="post" action="{{route('admin.exhibitcollect.getin_save')}}" class="form-horizontal ajaxForm">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">入馆凭证号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="id" id="id"
                                           value="{{$info['id'] or ''}}" required/>
                                    <input type="hidden" name="_token"
                                           value="{{csrf_token()}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">入馆凭证名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="minor" id="minor"
                                           value="{{$info['minor'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">入馆日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="major"  name="major"
                                           value="{{$info['major'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">收据号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="rssia" name="rssia"
                                           value="{{$info['rssia'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">备注</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="rssii" name="rssii"
                                           value="{{$info['rssii'] or ''}}" required/>
                                </div>
                            </div>

                            <div class="row m-b">
                                <div class="col-sm-12">
                                    <div class="tabs-container">
                                        <ul class="nav nav-tabs">
                                            <li ><a href="{{route('admin.exhibitcollect.getin_add')}}">新增</a></li>
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
                                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
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
                                                @foreach($exhibit_list as $exhibit)
                                                    <tr class="gradeA">
                                                        <td>{{$exhibit->exhibit_num}}</td>
                                                        <td>{{$exhibit->title}}</td>
                                                        <td><img width="50px" heighy='60px'src="{{$exhibit->squar_list_img}}"/></td>
                                                        <td>
                                                            <a href="{{url('/admin/data/exhibit_add?exhibit_id=' . $exhibit->exhibit_id)}}">编辑</a>
                                                            | <a class="ajaxBtn" href="javascript:void(0);" uri="{{url('/admin/data/exhibit_del?exhibit_id=' . $exhibit->exhibit_id)}}" msg="是否删除该文物？">删除</a>

                                                        </td>
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
@endsection


