@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="showmsg-div center-block">
        <h1 class="text-center number">404</h1>
        <p class="text-left center-block">对不起，您访问的页面暂时无法找到！</p>
        <button id="backBtn" class="btn btn-primary center-block">返回</button>
    </div>
    @if (isset($url))
        <script type="text/javascript">
            window.setTimeout("location.href='{!! $url !!}'", 4000);
        </script>
    @endif

@endsection
