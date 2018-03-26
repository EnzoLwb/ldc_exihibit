@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="" method="post" class="form-horizontal ajaxForm">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">原密码</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" name="old_password"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">新密码</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" name="password"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">确认密码</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" name="password_confirmation"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6 col-md-offset-2">
                                    <button class="btn btn-primary" type="submit">保存</button>
                                    <button class="btn btn-white" type="button" onclick="window.history.back()">返回</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

