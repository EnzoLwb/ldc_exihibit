@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.setting.systemlog')}}">系统日志</a></li>
                        <li class="active"><a href="javascript:void(0);">文件详情</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="col-sm-12 treeview">
                            <ul class="list-group">
                                <li class="list-group-item node-tree">
                                    {{$filepath}}
                                </li>
                            </ul>
                            <textarea class="form-control" style="width: 100%; height: 600px;">@foreach($filecontents as $c){{$c."\n"}}@endforeach</textarea>
                        </div>
                        <div class="row"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
