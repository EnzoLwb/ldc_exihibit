@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li @if($status == 1) class="active" @endif><a href="{{url('/admin/article/comment')}}">评论列表</a></li>
                        <li @if($status == 2) class="active" @endif><a href="{{url('/admin/article/comment/2')}}">待审核评论</a></li>
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
                                <input type="text" name="comment" placeholder="评论内容" class="form-control" value="{{request('comment')}}">
                            </div>
                            &nbsp;&nbsp;
                            <div class="form-group">
                                <label>发表时间</label>
                                <input placeholder="开始日期" class="form-control layer-date laydate-icon" id="start" type="text" name="add_time_from" value="{{request('add_time_from')}}"
                                       style="width: 140px;">
                                ~ <input placeholder="结束日期" class="form-control layer-date laydate-icon" id="end" type="text" name="add_time_to" value="{{request('add_time_to')}}"
                                         style="width: 140px;">
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{url('/admin/article/comment/'.$status)}}'">重置</button>
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
                                <th width="2%"><input type="checkbox" class="checkAll"></th>
                                {{--<th>作者ID</th>--}}
                                <th width="13%">作者</th>
                                <th width="20%">时间</th>
                                <th width="30%">评论内容</th>
                                <th width="20%">文章标题</th>
                                <th width="15%">操作</th>
                            </tr>
                            </thead>
                            @foreach($comments as $comment)
                                <tr class="gradeA">
                                    <td><input type="checkbox" class="checkItem" value="{{$comment['comment_id']}}"></td>
                                    {{--<td>{{$comment['uid']}}</td>--}}
                                    <td>{{$comment['uname']}}</td>
                                    <td>{{$comment['add_time']}}</td>
                                    <td>{{$comment['comment']}}</td>
                                    <td>{{$comment['title']}}</td>
                                    <td>
                                        <a class="ajaxBtn" href="javascript:void(0);" uri="{{url('/admin/article/comment/delete/' . $comment['comment_id'])}}" msg="是否删除这条评论？">删除</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-danger btn-sm checkBtn" uri="{{url('/admin/article/comment/delete')}}" msg="是否要删除这些评论？删除后不可恢复">删除</button>
                                @if($status == 2)
                                    <button type="button" class="btn btn-success btn-sm checkBtn" uri="{{url('/admin/article/comment/pass')}}">审核通过</button>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div>共 {{ $comments->total() }} 条记录</div>
                                {!! $comments->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{cdn('js/plugins/laydate/laydate.js')}}"></script>
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
