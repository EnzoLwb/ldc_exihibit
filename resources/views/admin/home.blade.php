@extends('layouts.public')

@section('title')
    {{ $system_name .' '. $system_version }}
@endsection

@section('head')
    <link rel="stylesheet" href="{{cdn('js/plugins/pace/pace.css')}}">
@endsection

@section('bodyattr')
    class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden"
@endsection

@section('body')
    <div id="wrapper">
        <div id="header" class="row content-tabs">
            <img src="{{get_file_url($system_logo)}}" id="logo-img"/>
            <div class="title">{{ $system_name .' '. $system_version }}</div>
            <div class="roll-nav" onclick="jQuery('iframe:visible').get(0).contentWindow.location.reload();">
                <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span><span class="fresh">刷新</span>
            </div>

            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <a class="mouse-toggle" href="#">
                            <span class="clear">
                            <span><strong class="font-bold">{{ Auth::user()->username }}</strong></span>
                            <span class="text-muted text-xs"><b class="caret"></b></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('admin.setting.basesetting.clearcache') }}" class="ajaxBtn">刷新缓存</a></li>
                            <li><a href="{{ route('admin.setting.adminusers.password') }}" target="rIframe">修改密码</a></li>
                            <li><a href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">安全退出</a></li>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </ul>
                    </div>
                </li>
            </ul>

        </div>
        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation" style="overflow-y:auto">

            <div class="nav-close"><i class="fa fa-times-circle"></i>
            </div>
            <div class="sidebar-collapse">
                @include('admin.menu')
            </div>
        </nav>
        <!--左侧导航结束-->
        <!--右侧部分开始-->
        <div id="page-wrapper" class="gray-bg dashbard-1">

            <div class="row J_mainContent" id="content-main">
                <iframe class="J_iframe" name="rIframe" id="rIframe" width="100%" height="100%" frameborder="0" src="{{route('admin.welcome')}}"></iframe>
            </div>
        </div>
        <!--右侧部分结束-->
    </div>
@endsection

@section('script')
    <script src="{{cdn('js/plugins/pace/pace.min.js')}}"></script>
    <script>
        $(".search-nav").css("right", 80 + $("#side-menu").width());
        $(".dropdown").mouseover(function () {
            $(".dropdown-menu").show();
        });
        $(".dropdown").mouseout(function () {
            $(".dropdown-menu").hide();
        })
    </script>
@endsection
