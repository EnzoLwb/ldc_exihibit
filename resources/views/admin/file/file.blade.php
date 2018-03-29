@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b-md">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.file.file')}}">文件列表</a></li>
                        {{--<li><a href="{{url('/admin/file/file/unsave')}}">游离文件列表</a></li>--}}
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
                                <label class="sr-only">原始文件名</label>
                                <input type="text" name="file_oldname" placeholder="原始文件名" class="form-control" value="{{request('file_oldname')}}">
                            </div>
                            &nbsp;&nbsp;
                            <div class="form-group">
                                <label>添加时间</label>
                                <input placeholder="开始日期" class="form-control layer-date laydate-icon" id="start" type="text" name="created_at_from" value="{{request('created_at_from')}}"
                                       style="width: 140px;">
                                ~ <input placeholder="结束日期" class="form-control layer-date laydate-icon" id="end" type="text" name="created_at_to" value="{{request('created_at_to')}}"
                                         style="width: 140px;">
                            </div>
                            &nbsp;&nbsp;
                            <div class="form-group">
                                <select class="form-control" name="file_status">
                                    <option value="">状态</option>
                                    @foreach($fileStatus as $k => $status)
                                        <option value="{{$k}}" @if(request('file_status') === "$k") selected="selected"@endif>{{$status}}</option>
                                    @endforeach
                                </select>
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.file.file')}}'">重置</button>
                        </form>
                    </div>
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
                                <th width="2%"><input type="checkbox" class="checkAll"/></th>
                                <th width="5%">ID</th>
                                <th width="11%">文件MIME</th>
                                <th width="25%">文件名 (原始文件名)</th>
                                <th width="10%" class="sorting" orderby="file_size">文件大小</th>
                                <th width="15%">存储路径</th>
                                <th width="11%" class="sorting_desc" orderby="created_at">添加时间</th>
                                {{--<th width="7%">状态</th>--}}
                                <th>操作</th>
                            </tr>
                            </thead>
                            @foreach($files as $file)
                                <tr class="gradeA">
                                    <td><input type="checkbox" class="checkItem" value="{{$file['file_id']}}"/></td>
                                    <td>{{$file['file_id']}}</td>
                                    <td>{{$file['file_mime']}}</td>
                                    <td>{{$file['file_name']}}<br/>({{$file['file_oldname']}})</td>
                                    <td>{{file_size_format($file['file_size'])}}</td>
                                    <td>{{$file['file_path']}}</td>
                                    <td>{{$file['created_at']}}</td>
                                    {{--<td>{{$fileStatus[$file['file_status']]}}</td>--}}
                                    <td>
                                        <a href="{{url('/admin/file/file/download/' . $file['file_id'])}}" target="_self">下载</a>
                                        | <a class="ajaxBtn" href="javascript:void(0);" uri="{{route('admin.file.file.delete',[$file['file_id']])}}" msg="是否删除此文件？">删除</a>
                                        {{--@if($file['file_status'] == '0')--}}
                                        {{--| <a class="ajaxBtn" href="javascript:void(0);" uri="{{url('/admin/file/file/check/' . $file['file_id'])}}">验证</a>--}}
                                        {{--@endif--}}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-danger btn-sm checkBtn" uri="{{route('admin.file.file.delete')}}" msg="是否要删除这些文件？删除后不可恢复">删除</button>
                                {{--<button type="button" class="btn btn-success btn-sm checkBtn" uri="{{url('/admin/file/file/check')}}">验证</button>--}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div>共 {{ $files->total() }} 条记录</div>
                                {!! $files->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{cdn('js/plugins/laydate/laydate.js')}}"></script>
    <script type="text/javascript">
        var start = {
            elem: "#start", format: "YYYY-MM-DD", max: laydate.now(),
            isclear: false,
            istoday: false,
            issure: false,
            choose: function (datas) {
                end.min = datas;
                end.start = datas;
            }
        };
        var end = {
            elem: "#end", format: "YYYY-MM-DD", max: laydate.now(),
            isclear: false,
            istoday: false,
            issure: false,
            choose: function (datas) {
                start.max = datas
            }
        };
        laydate(start);
        laydate(end);
    </script>
@endsection