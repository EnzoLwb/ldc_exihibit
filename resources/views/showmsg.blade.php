@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
	<div class="showmsg-div center-block">
	    <h1 class="text-center">@if($status)  <img src="{{cdn('img/success_icon.png')}}"> @else  <img src="{{cdn('img/error_icon.png')}}"> @endif</h1>
	    <p class="text-left center-block">{{$msg}}</p>

	    <button id="backBtn" class="btn btn-primary center-block">返回</button>
    </div>
    @if (isset($url))
        <script type="text/javascript">
            window.setTimeout("location.href='{!! $url !!}'", 4000);
        </script>
    @endif

@endsection