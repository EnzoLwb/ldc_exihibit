@extends('layouts.public')

@section('head')
    <link rel="stylesheet" href="{{cdn('css/plugins/webuploader.css')}}">
    <link rel="stylesheet" href="{{cdn('css/demo/webuploader-demo.min.css')}}">
    <style type="text/css">
        .progress {
            margin-bottom: 0px;
            height: 14px;
        }

        #picker {
            display: inline-block;
            vertical-align: middle;
            margin: 0 12px 0 0;
        }
    </style>
@endsection

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div id="uploader" class="wu-example">
                            <table id="thelist" class="table table-striped table-bordered table-hover dataTables-example dataTable">
                                <thead>
                                <tr role="row">
                                    <td width="30%">文件名</td>
                                    <td width="10%">大小</td>
                                    <td width="15%">类型</td>
                                    <td width="20%">MD5</td>
                                    <td width="20%">状态</td>
                                    <td width="5%"></td>
                                </tr>
                                </thead>
                            </table>
                            <div class="btns">
                                <div id="picker">选择文件</div>
                                <button id="ctlBtn" class="btn btn-white">开始上传</button>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
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
            var $btn = $('#ctlBtn'), state = 'pending';
            var md5Array = [];
            var partMd5Array = [];

            WebUploader.Uploader.register({
                'before-send': 'checkChunk'
            }, {
                checkChunk: function (block) {
                    var file = block.file;
                    var deferred = $.Deferred();

                    if (block.chunks > 1) {
                        uploader.md5File(block.blob).then(function (blobmd5) {
                            md5Array[file.id + '_' + block.chunk] = blobmd5;
                            if ($.inArray(blobmd5, partMd5Array) > -1) {
                                deferred.reject();
                            } else {
                                deferred.resolve();
                            }
                        });
                    } else {
                        deferred.resolve();
                    }

                    return deferred.promise();
                }
            });

            var uploader = WebUploader.create({
                swf: '/js/plugins/webuploader/Uploader.swf',
                server: '{{route('admin.file.file.multiupload')}}',
                pick: '#picker',
                compress: false,
                chunked: true,
                chunkSize: 1024 * 1024,
                threads: 2,
                formData: {
                    '_token': '{{csrf_token()}}'
                }
            });

            uploader.on('fileQueued', function (file) {
                file.setStatus('cancelled');
                $('#thelist').append('<tr class="gradeA" id="' + file.id + '">' +
                    '<td>' + file.name + '</td>' + '<td>' + WebUploader.formatSize(file.size) + '</td>' + '<td>' + file.type + '</td>' +
                    '<td id="md5progress">计算MD5中...<div class="progress progress-striped active"><div style="width: 0%" role="progressbar" class="progress-bar progress-bar-success"></div></div></td>' +
                    '<td class="stateTd"><span class="state">等待上传...</span></td>' +
                    '<td><a href="javascript:void(0);" id="del' + file.id + '">删除</a></td>' +
                    '</tr>');
                uploader.md5File(file).progress(function (percentage) {
                    $('#' + file.id + ' .progress-bar').css('width', percentage.toFixed(2) * 100 + '%');
                }).then(function (filemd5) {
                    $('#' + file.id + ' #md5progress').html(filemd5);
                    md5Array[file.id] = filemd5;
                    $.ajax({
                        url: '/admin/file/file/checkmfile',
                        type: 'get',
                        data: 'name=' + encodeURIComponent(file.name) + '&md5=' + filemd5,
                        async: false,
                        success: function (data) {
                            partMd5Array = data;
                        }
                    });
                    file.setStatus('queued');
                });
                $('#del' + file.id).click(function () {
                    $(this).parents('tr').remove();
                    uploader.cancelFile(file);
                });
            });

            uploader.on('uploadProgress', function (file, percentage) {
                var $li = $('#' + file.id + ' .stateTd'),
                    $percent = $li.find('.progress .progress-bar');

                if (!$percent.length) {
                    $percent = $('<div class="progress progress-striped active">' +
                        '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                        '</div>' +
                        '</div>').appendTo($li).find('.progress-bar');
                }

                $li.find('.state').text('上传中');

                $percent.css('width', percentage * 100 + '%');
            });

            uploader.on('uploadBeforeSend', function (block, data, headers) {
                data.chunkmd5 = md5Array[block.file.id + '_' + block.chunk];
                data.md5 = md5Array[block.file.id];
            });

            uploader.on('uploadSuccess', function (file) {
                $('#' + file.id).find('.state').text('已上传');
            });

            uploader.on('uploadError', function (file) {
                $('#' + file.id).find('.state').text('上传出错');
            });

            uploader.on('uploadComplete', function (file) {
                $('#' + file.id).find('.progress').fadeOut();
            });

            uploader.on('all', function (type) {
                if (type === 'startUpload') {
                    state = 'uploading';
                } else if (type === 'stopUpload') {
                    state = 'paused';
                } else if (type === 'uploadFinished') {
                    state = 'done';
                }

                if (state === 'uploading') {
                    $btn.text('暂停上传');
                } else {
                    $btn.text('开始上传');
                }
            });

            $btn.on('click', function () {
                if (state === 'uploading') {
                    uploader.stop(true);
                } else {
                    uploader.upload();
                }
            });

        });
    </script>
@endsection