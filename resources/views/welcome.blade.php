@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="middle-box text-center">
        <h1>欢迎</h1>

        <div>
            @if (Auth::check())
                <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    登出
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @else
                <a href="{{ url('/login') }}">登录</a>
                <a href="{{ url('/register') }}">注册</a>
            @endif
        </div>
    </div>
@endsection