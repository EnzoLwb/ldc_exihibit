@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b-md">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{url('/file/file')}}">文件列表</a></li>
                        <li class="active"><a href="{{url('/file/file/unsave')}}">游离文件列表</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get">
                            <div class="form-group">
                                <div class="input-group m-b-xs">
                                    <span class="input-group-addon">{{env('FILE_PATH', '')}}</span>
                                    <input type="text" name="dir" placeholder="可输入目录名进行筛选" class="form-control" value="{{request('dir')}}">
                                </div>
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='/file/file/unsave'">重置</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form method="post" id="unsave_form">
                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
                                {!! csrf_field() !!}
                                <thead>
                                <tr role="row">
                                    <th width="5%"><input type="checkbox" class="checkAll"/></th>
                                    <th>文件完整路径</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                @foreach($files as $file)
                                    <tr class="gradeA">
                                        <td><input type="checkbox" class="checkItem" name="objects[]" value="{{$file}}"/></td>
                                        <td>{{$file}}</td>
                                        <td>
                                        <!--
                                        <a href="{{url('/file/file/download/')}}" target="_blank">下载</a>
                                        | <a href="{{url('/file/file/delete/')}}" onclick="javascript:if(confirm('是否删除此文件？')){ return true } else { return false };">删除</a>
                                        | <a href="{{url('/file/file/check/')}}" ajax="1">验证</a>
                                        -->
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <div class="row">
                                <div class="col-sm-12">
                                <!--
                                <button type="button" class="btn btn-danger btn-sm checkBtn" uri="{{url('/file/file/delete')}}" msg="是否要删除这些文件？删除后不可恢复">删除</button>
                                <button type="button" class="btn btn-success btn-sm checkBtn" uri="{{url('/file/file/check')}}">验证</button>
                                -->
                                    <button type="submit" class="btn btn-success btn-sm">录入文件信息</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-sm-12">
                                @if ($nextMarker != '')
                                    <ul class="pagination">
                                        <li><a href="{{url('/file/file/unsave?next=' . $nextMarker . '&dir=' .  request('dir') )}}" rel="next">下一页</a></li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        jQuery(function ($) {
            $('#unsave_form').submit(function () {
                if ($('.checkItem:checked').length > 0) {
                    return true;
                } else {
                    alert('请至少选择一项');
                    return false;
                }
            });
        });
    </script>
@endsection