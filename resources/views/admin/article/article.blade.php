@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{url('/admin/article/article')}}">文章列表</a></li>
                        <li><a href="{{url('/admin/article/article/add')}}">添加文章</a></li>
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
                                <input type="text" name="title" placeholder="标题" class="form-control" value="{{request('title')}}">
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
                                <select class="form-control" name="cate_id">
                                    <option value="">分类</option>
                                    @foreach ($cates as $cate)
                                        @if ($cate['layer'] == 2)
                                            <option value="{{$cate['cate_id']}}" @if (request('cate_id') == $cate['cate_id']) selected="selected"@endif>{{$cate['cate_name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            &nbsp;&nbsp;
                            <div class="form-group">
                                <select class="form-control" name="is_show">
                                    <option value="">是否显示</option>
                                    <option value="1" @if (request('is_show') == '1') selected="selected" @endif>显示</option>
                                    <option value="0" @if (request('is_show') == '0') selected="selected" @endif>不显示</option>
                                </select>
                            </div>
                            &nbsp;
                            <div class="form-group">
                                <select class="form-control" name="is_comment">
                                    <option value="">是否允许评论</option>
                                    <option value="1" @if (request('is_comment') == '1') selected="selected" @endif>允许评论</option>
                                    <option value="0" @if (request('is_comment') == '0') selected="selected" @endif>不允许评论</option>
                                </select>
                            </div>
                            &nbsp;
                            <div class="form-group">
                                <select class="form-control" name="is_top">
                                    <option value="">是否置顶</option>
                                    <option value="1" @if (request('is_top') == '1') selected="selected" @endif>置顶</option>
                                    <option value="0" @if (request('is_top') == '0') selected="selected" @endif>不置顶</option>
                                </select>
                            </div>
                            &nbsp;
                            <div class="form-group">
                                <select class="form-control" name="is_recommend">
                                    <option value="">是否推荐</option>
                                    <option value="1" @if (request('is_recommend') == '1') selected="selected" @endif>推荐</option>
                                    <option value="0" @if (request('is_recommend') == '0') selected="selected" @endif>不推荐</option>
                                </select>
                            </div>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{url('/admin/article/article')}}'">重置</button>
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
                                <th>ID</th>
                                <th>标题</th>
                                <th>分类</th>
                                <th>作者</th>
                                <th>来源</th>
                                <th class="sorting" orderby="views">访问量</th>
                                <th class="sorting" orderby="comments">评论量</th>
                                <th class="sorting" orderby="created_at">添加时间</th>
                                <th>状态</th>
                                <th>评论</th>
                                <th>置顶</th>
                                <th>推荐</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            @foreach($articles as $article)
                                <tr class="gradeA">
                                    <td><input type="checkbox" class="checkItem" value="{{$article['article_id']}}"></td>
                                    <td>{{$article['article_id']}}</td>
                                    <td>{{$article['title']}}</td>
                                    <td>{{$cates[$article['cate_id']]['cate_name'] or ''}}</td>
                                    <td>{{$article['uid']}}</td>
                                    <td>{{$article['source']}}</td>
                                    <td>{{$article['views']}}</td>
                                    <td>{{$article['comments']}}</td>
                                    <td>{{$article['created_at']}}</td>
                                    <td>@if ($article['is_show'] == 1) 显示 @else 不显示 @endif</td>
                                    <td>@if ($article['is_comment'] == 1) 允许 @else 不允许 @endif</td>
                                    <td>@if ($article['is_top'] == 1) 置顶 @else 不置顶 @endif</td>
                                    <td>@if ($article['is_recommend'] == 1) 推荐 @else 不推荐 @endif</td>
                                    <td>
                                        <a href="{{url('/admin/article/article/edit/' . $article['article_id'])}}">编辑</a>
                                        | <a class="ajaxBtn" href="javascript:void(0);" uri="{{url('/admin/article/article/delete/' . $article['article_id'])}}" msg="是否删除该文章及相关评论？">删除</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-danger btn-sm checkBtn" uri="{{url('/admin/article/article/delete')}}" msg="是否要删除这些文章及相关评论？删除后不可恢复">删除</button>
                                <button type="button" class="btn btn-success btn-sm checkBtn" uri="{{url('/admin/article/article/batch/is_show/1')}}">显示</button>
                                <button type="button" class="btn btn-success btn-sm checkBtn" uri="{{url('/admin/article/article/batch/is_show/0')}}">不显示</button>
                                <button type="button" class="btn btn-success btn-sm checkBtn" uri="{{url('/admin/article/article/batch/is_top/1')}}">置顶</button>
                                <button type="button" class="btn btn-success btn-sm checkBtn" uri="{{url('/admin/article/article/batch/is_top/0')}}">取消置顶</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div>共 {{ $articles->total() }} 条记录</div>
                                {!! $articles->links() !!}
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
                if ($("#end").val() !== null && $("#end").val() !== '' && $("#end").val() < $('#start').val()) {
                    $("#end").val(datas);
                }
                end.min = datas;
                end.start = datas;
            }
        };
        var end = {
            elem: "#end", format: "YYYY-MM-DD", max: laydate.now(),
            @if(request('created_at_from'))
            min: $("#start").val(),
            @endif
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
