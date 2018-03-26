@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="showmsg-div center-block">
        <h1 class="text-center number">错误</h1>
        <p class="text-left center-block">对不起，您访问的页面已过期，请返回刷新后重试！</p>
        <button id="backBtn" class="btn btn-primary center-block" url="{{url()->previous()}}">返回</button>
    </div>
@endsection
