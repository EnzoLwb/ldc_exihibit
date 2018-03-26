@extends('layouts.public')

@section('head')
    <link rel="stylesheet" href="{{cdn('css/plugins/webuploader.css')}}">
    <link rel="stylesheet" href="{{cdn('css/demo/webuploader-demo.min.css')}}">
    <style type="text/css">
        .progress {
            margin-bottom: 0px;
            height: 14px;
        }
    </style>
@endsection

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <form method="post" id="uploadinfo_form">
                        {{csrf_field()}}
                        <div class="ibox-title">
                            <div id="uploader" class="wu-example">
                                <div class="btns">
                                    <div id="picker">选择文件</div>
                                </div>
                            </div>
                            <table id="thelist" class="table table-striped table-bordered table-hover dataTables-example dataTable">
                                <thead>
                                <tr role="row">
                                    <td width="35%">文件名</td>
                                    <td width="15%">大小</td>
                                    <td width="15%">类型</td>
                                    <td width="25%">MD5</td>
                                    <td></td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="ibox-content">
                            <input type="submit" class="btn btn-primary" value="保存文件信息"/>
                            <span>保存完成后，请通过其他方式将文件上传到OSS，然后从文件列表中进行验证</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{cdn('js/plugins/webuploader/webuploader.nolog.min.js')}}"></script>
    <script type="text/javascript">
        jQuery(function ($) {
            var uploader = WebUploader.create({
                swf: '/js/plugins/webuploader/Uploader.swf',
                pick: '#picker',
            });

            uploader.on('fileQueued', function (file) {
                $('#thelist').append('<tr class="gradeA" id="' + file.id + '">' +
                        '<td>' + file.name + '</td>' + '<td>' + WebUploader.formatSize(file.size) + '</td>' + '<td>' + file.type + '</td>' +
                        '<td id="md5progress">计算MD5中...<div class="progress progress-striped active"><div style="width: 0%" role="progressbar" class="progress-bar progress-bar-success"></div></div></td>' +
                        '<td><a href="javascript:void(0);" onclick="jQuery(\'#info_'+file.id+',#'+ file.id + '\').remove();">删除</a></td>' +
                        '</tr>');


                uploader.md5File(file).progress(function (percentage) {
                    $('#' + file.id + ' .progress-bar').css('width', percentage.toFixed(2) * 100 + '%');
                }).then(function (filemd5) {
                    $('#' + file.id + ' #md5progress').html(filemd5);
                    $('#uploadinfo_form').append('<div id="info_' + file.id + '">' +
                            '<input type="hidden" name="file_name[]" value="' + file.name + '" />' +
                            '<input type="hidden" name="file_size[]" value="' + file.size + '" />' +
                            '<input type="hidden" name="file_mime[]" value="' + file.type + '" />' +
                            '<input type="hidden" name="file_md5[]" value="' + filemd5 + '" />' +
                            '</div>');
                });
            });
        });
    </script>
@endsection