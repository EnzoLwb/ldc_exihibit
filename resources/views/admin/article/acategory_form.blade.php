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
                        <li class=""><a href="{{url('/admin/article/acategory')}}">分类列表</a></li>
                        <li @if (!isset($category))class="active"@endif><a href="{{url('/admin/article/acategory/add')}}">添加分类</a></li>
                        @if (isset($category))
                            <li class="active"><a href="#">编辑分类</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="{{url('/admin/article/acategory/save')}}" method="post" class="form-horizontal ajaxForm">
                            <input type="hidden" name="cate_id" value="{{$category->cate_id or 0}}"/>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">分类名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="cate_name" value="{{$category->cate_name or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">上级分类</label>
                                <div class="col-sm-4">
                                    <select name="parent_id" class="form-control">
                                        <option value="0">一级分类</option>
                                        @foreach ($cates as $cate)
                                            <option value="{{$cate['cate_id']}}"
                                                    @if ((isset($category->parent_id) ? $category->parent_id : '') == $cate['cate_id'] || request('cate_id') == $cate['cate_id']) selected="selected" @endif>
                                                &nbsp;&nbsp;
                                                @if($cate['layer'] == 1)
                                                @elseif($cate['layer'] == 2)
                                                    &nbsp;&nbsp;
                                                @elseif($cate['layer'] == 3)
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                @endif
                                                {{$cate['cate_name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">排序</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="sort_order" value="{{$category->sort_order or '255'}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">图标</label>
                                <div class="col-sm-10" id="imgupload">
                                    <div id="filePicker">选择图片</div>
                                    <button class="btn btn-white" type="button" id="clearimg">清除图片</button>
                                    @if(isset($category) && $category->icon != '')
                                        <img src="{{get_file_url($category->icon)}}" style="height:100px;" id="imgpreview"/>
                                    @endif
                                </div>
                                <input type="hidden" name="icon" id="icon" value="{{$category->icon or ''}}"/>
                                <input type="hidden" name="file_id" id="file_id" value="0"/>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">状态</label>
                                <div class="col-sm-10">
                                    <div class="input-group m-t-xs-2">
                                        <input type="radio" class="" name="is_show" value="1"
                                               @if ((isset($category->is_show) ? $category->is_show : '') != '0') checked="checked"@endif/>显示
                                        <input type="radio" name="is_show" value="0"
                                               @if ((isset($category->is_show) ? $category->is_show : '') == '0') checked="checked"@endif/>不显示
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    @if (isset($category))
                                        <button class="btn btn-primary" type="submit">保存</button>
                                        <button class="btn btn-white" type="button" onclick="window.history.back()">返回</button>
                                    @else
                                        <button class="btn btn-primary" type="submit">添加</button>
                                        <button class="btn btn-white" type="reset" id="reset">重置</button>
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
                    'item_id': '{{$category->cate_id or 0}}',
                    'type_key': 'FT_ARTICLE_CATE'
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
                        $imgbox.append('<img src="" style="height:100px;" id="imgpreview" />');
                    }
                    $img = $('#imgpreview');
                    $img.prop('src', response.data.file_path);
                    $('#icon').val(response.data.file_path);
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
                $('#icon').val('');
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
