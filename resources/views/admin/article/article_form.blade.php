@extends('layouts.public')

@section('head')
    <style type="text/css">
        .webuploader-container {
            position: relative;
        }

        .webuploader-element-invisible {
            position: absolute !important;
            clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
            clip: rect(1px, 1px, 1px, 1px);
        }

        .webuploader-pick {
            position: relative;
            display: inline-block;
            cursor: pointer;
            border-color: #00b7ee;
            background: #00b7ee;
            font-size: 14px;
            font-weight: 400;
            padding: 6px 12px;
            color: #fff;
            text-align: center;
            border-radius: 3px;
            overflow: hidden;
        }

        .webuploader-pick-hover {
            background: #00a2d4;
        }

        .webuploader-pick-disable {
            opacity: 0.6;
            pointer-events: none;
        }
    </style>
@endsection

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{url('/admin/article/article')}}">文章列表</a></li>
                        <li @if (!isset($article))class="active"@endif><a href="{{url('/admin/article/article/add')}}">添加文章</a></li>
                        @if (isset($article))
                            <li class="active"><a href="#">编辑文章</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="{{url('/admin/article/article/save')}}" method="post" class="form-horizontal ajaxForm">
                            <input type="hidden" name="article_id" value="{{$article->article_id or 0}}"/>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">标题</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="title" value="{{$article->title or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">副标题</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="sub_title" value="{{$article->sub_title or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文章来源</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="source" value="{{$article->source or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">关键词</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="keywords" value="{{$article->keywords or ''}}" placeholder="多个词请用逗号分隔"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">所属分类</label>
                                <div class="col-sm-6">
                                    <select name="cate_id" class="form-control">
                                        <option value="">--请选择分类--</option>
                                        @foreach ($cates as $cate)
                                            @if ($cate['layer'] < 2)
                                                <option value="" disabled="disabled">--{{$cate['cate_name']}}--</option>
                                            @else
                                                <option value="{{$cate['cate_id']}}"
                                                        @if ((isset($article->cate_id) ? $article->cate_id : '') == $cate['cate_id']) selected="selected"@endif>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;{{$cate['cate_name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文章头图</label>
                                <div class="col-sm-10" id="imgupload">
                                    <div id="filePicker">选择图片</div>
                                    <button class="btn btn-white" type="button" id="clearimg">清除图片</button>
                                    @if(isset($article) && $article->default_img != '')
                                        <img src="{{get_file_url($article->default_img)}}" style="height:120px;" id="imgpreview"/>
                                    @endif
                                </div>
                                <input type="hidden" name="default_img" id="default_img" value="{{$article->default_img or ''}}"/>
                                <input type="hidden" name="file_id" id="file_id" value="0"/>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">简介</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="des">{{$article->des or ''}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">内容</label>
                                <div class="col-sm-10">
                                    <textarea name="content" id="content">{{$article->content or ''}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">状态</label>
                                <div class="col-sm-10">
                                    <div class="input-group m-t-xs-2">
                                        <input type="radio" name="is_show" value="1"
                                               @if ((isset($article->is_show) ? $article->is_show : '') != '0') checked="checked"@endif/>显示
                                        <input type="radio" name="is_show" value="0"
                                               @if ((isset($article->is_show) ? $article->is_show : '') == '0') checked="checked"@endif/>不显示
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">评论</label>
                                <div class="col-sm-10">
                                    <div class="input-group m-t-xs-2">
                                        <input type="radio" name="is_comment" value="1"
                                               @if ((isset($article->is_comment) ? $article->is_comment : '') != '0') checked="checked"@endif/>允许
                                        <input type="radio" name="is_comment" value="0"
                                               @if ((isset($article->is_comment) ? $article->is_comment : '') == '0') checked="checked"@endif/>不允许
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">置顶</label>
                                <div class="col-sm-10">
                                    <div class="input-group m-t-xs-2">
                                        <input type="radio" name="is_top" value="1"
                                               @if ((isset($article->is_top) ? $article->is_top : '') == '1') checked="checked"@endif/>置顶
                                        <input type="radio" name="is_top" value="0"
                                               @if ((isset($article->is_top) ? $article->is_top : '') != '1') checked="checked"@endif/>不置顶
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">推荐</label>
                                <div class="col-sm-10">
                                    <div class="input-group m-t-xs-2">
                                        <input type="radio" name="is_recommend" value="1"
                                               @if ((isset($article->is_recommend) ? $article->is_recommend : '') == '1') checked="checked"@endif/>推荐
                                        <input type="radio" name="is_recommend" value="0"
                                               @if ((isset($article->is_recommend) ? $article->is_recommend : '') != '1') checked="checked"@endif/>不推荐
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    @if (isset($article))
                                        <button class="btn btn-primary" type="submit">保存</button>
                                        <button class="btn btn-white" type="button" onclick="window.history.back()">返回</button>
                                    @else
                                        <button class="btn btn-primary" type="submit">添加</button>
                                        <button class="btn btn-white" type="reset">重置</button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script src="{{cdn('js/plugins/ueditor/ueditor.config.js')}}"></script>
    <script src="{{cdn('js/plugins/ueditor/ueditor.all.min.js')}}"></script>
    <script src="{{cdn('js/plugins/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    <script type="text/javascript">
        jQuery(function ($) {
            var ue = UE.getEditor('content');

            ue.ready(function () {
                ue.execCommand('serverparam', {
                    '_token': '{{csrf_token()}}',
                    'filetype': 'FT_ARTICLE_DESC',
                    'itemid': '{{$article->article_id or 0}}'
                });
            });
        });
    </script>
    <script src="{{cdn('js/plugins/webuploader/webuploader.nolog.min.js')}}"></script>
    <script type="text/javascript">
        jQuery(function ($) {
            var BASE_URL = '/', $img;
            var $imgbox = $('#imgupload');
            var uploader = WebUploader.create({
                auto: true,
                swf: BASE_URL + '/js/plugins/webuploader/Uploader.swf',
                server: '/admin/upload',
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/gif,image/jpeg,image/png,image/bmp'
                },
                formData: {
                    'ajax': 1,
                    '_token': '{{csrf_token()}}',
                    'item_id': '{{$article->article_id or 0}}',
                    'type_key': 'FT_ARTICLE_IMG'
                },
                pick: '#filePicker',
            });

            uploader.on('fileQueued', function (file) {
                $imgbox.removeClass('has-error');
                $imgbox.find('.help-block').remove();
            });

            uploader.on('uploadSuccess', function (file, response) {
                if (response.status == true) {
                    if ($('#imgpreview').length == 0) {
                        $imgbox.append('<img src="" style="height:120px;" id="imgpreview" />');
                    }
                    $img = $('#imgpreview');
                    $img.prop('src', response.data.file_path);
                    $('#default_img').val(response.data.file_path);
                    $('#file_id').val(response.data.file_id);
                } else {
                    showError(response.msg);
                }
            });

            uploader.on('uploadError', function (file) {
                showError('上传失败，请刷新页面后重新尝试');
            });
            uploader.on('uploadComplete', function (file) {
                uploader.reset();
            });

            function showError(msg) {
                $imgbox.addClass('has-error');
                $imgbox.append('<span class="help-block"><strong>' + msg + '</strong></span>');
            }

            function removeImg() {
                $('#imgpreview').remove();
                $('#default_img').val('');
                $('#file_id').val(0);
            }

            $('#clearimg').click(function () {
                removeImg();
            });
            $('#reset').click(function () {
                removeImg();
                return true;
            });
        });
    </script>
@endsection
