@extends('layouts.public')

@section('head')


@endsection

@section('body')

    <div class="wrapper wrapper-content">
        <button onclick="upload_resource('单文件上传','FT_ONE_RESOURCE','one_img',1);" class="btn btn-white">单图片上传</button>
        <div id="one_img">
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <button onclick="upload_resource('多文件上传','FT_MORE_RESOURCE','more_img',1);" class="btn btn-white">多图片上传</button>
        <div id="more_img">
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <input type="text" readonly name="audio" value="" id="audio" style="width: 500px">
        <button onclick="upload_resource('单文件上传','FT_ONE_MP3','audio',2);" class="btn btn-white">单资源上传</button>
    </div>
@endsection

@section('script')
    <link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">
    <script src="{{cdn('js/plugins/upload_resource/upload_resource.js')}}"></script>
@endsection