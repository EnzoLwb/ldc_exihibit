@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.repaireexhibit.repairin')}}">内修文物管理</a></li>
                        <li><a href="{{route('admin.repaireexhibit.repairin.add')}}">新增内修文物</a></li>
                        <li><a href="{{route('admin.repaireexhibit.repairout')}}">外修文物管理</a></li>
                        <li @if(!isset($data))class="active"@endif><a href="{{route('admin.repaireexhibit.repairout.add')}}">新增外修文物</a></li>
                        @if(isset($data))
                            <li class="active"><a href="#">编辑外修文物</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="{{route('admin.repaireexhibit.apply.save')}}" method="post" class="form-horizontal ajaxForm">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">图片</label>
                                <div class="col-sm-4">
                                    修复前
                                    修复中
                                    修复后
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">藏品名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                    分类号
                                    总登记号
                                    年代
                                    质地
                                    藏品级别
                                    件套数
                                    尺寸
                                    重量
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">残损情况</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复要求</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">时间</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">修复数量</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">估价</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">专家签字</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
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
