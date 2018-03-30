@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.storageroommanage.peopleinoutmanage')}}">查询</a></li>
                        <li><a href="{{route('admin.storageroommanage.peopleinoutmanage')}}">修改</a></li>
                        <li><a href="{{route('admin.storageroommanage.peopleinoutmanage')}}">删除</a></li>
                        <li><a href="{{route('admin.storageroommanage.peopleinoutmanage')}}">导出</a></li>
                        <li><a href="{{route('admin.storageroommanage.peopleinoutmanage')}}">打印</a></li>
                        <li><a href="{{route('admin.storageroommanage.peopleinoutmanage')}}">图文模式</a></li>
                        <li ><a href="{{route('admin.storageroommanage.peopleinoutmanage.add')}}">新增</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="{{route('admin.storageroommanage.peopleinoutmanage.save')}}" method="post" class="form-horizontal ajaxForm">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">入库时间</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">计划出库时间</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">入库人员</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">陪同人员</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">实际出库时间</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">进库人单位</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">出入事由</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">备注</label>
                                <div class="col-sm-4">
                                    <textarea name="" class="form-control"></textarea>
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
