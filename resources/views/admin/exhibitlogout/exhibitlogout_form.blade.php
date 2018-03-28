@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.exhibitlogout')}}">藏品注销</a></li>
                        <li @if(!isset($data))class="active"@endif><a href="{{route('admin.exhibitlogout.add')}}">新增</a></li>
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
                        <form action="{{route('admin.exhibitlogout.save')}}" method="post" class="form-horizontal ajaxForm">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">注销凭证号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">注销凭证名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">注销日期</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">注销批准文号</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">注销原因</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">详情描述</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">登记人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">登记日期</label>
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
