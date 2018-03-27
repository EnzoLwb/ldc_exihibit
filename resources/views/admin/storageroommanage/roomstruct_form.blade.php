@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.storageroommanage.roomstruct')}}">库房结构管理</a></li>
                        <li @if(!isset($data))class="active"@endif><a href="{{route('admin.storageroommanage.roomstruct.add')}}">新增</a></li>
                        @if(isset($data))
                            <li class="active"><a href="#">编辑</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="{{route('admin.storageroommanage.roomstruct.save')}}" method="post" class="form-horizontal ajaxForm">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房库位名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房库位编号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">是否库位</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="">
                                        <option value="">是</option>
                                        <option value="">否</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房类型</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">存储方式</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库房大小</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">是否生效</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="">
                                        <option value="">是</option>
                                        <option value="">否</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">位置</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">负责人</label>
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
