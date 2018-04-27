@extends('layouts.public')

@section('title', '登录')
<style type="text/css">
    *{
        font-size:100%;
    }
    input, textarea {
        color: #000;
    }

    .placeholder {
        color: #aaa;
    }
</style>
@section('body')
    <div style="height: 100%;  width: 100%; background: url(../img/bg.jpg) center center;    background-size: 100% 100%;    min-width: 1200px;    overflow: hidden;">
    <div class="middle-box text-center loginscreen">
        <div id="loginBox" style="    width: 98%;
    height: 320px;
    margin-left: -192%;
    margin-top: 132%;
    float: left;
    position: relative; ">
            <h3>{{$system_name}}</h3>

            <form class="m-t" role="form" method="POST" action="{{ route('admin.login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    <input type="text" name="username" class="form-control" placeholder="手机/邮箱/用户名" required="" value="{{ old('username') }}"/>
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" name="password" class="form-control" placeholder="密码" required="">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                @if ($captchaadminlogin)
                    <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                        <input type="text" name="captcha" class="form-control" placeholder="验证码" required="" style="width: 150px; float: left;"/>
                        <img src="{{ url('cpt/show') }}" onclick="this.src='{{ url('cpt/show') }}?r=' + Math.random();" title="看不清，换一个" style="cursor:pointer;"/>
                        @if ($errors->has('captcha'))
                            <span class="help-block">
                            <strong>{{ $errors->first('captcha') }}</strong>
                        </span>
                        @endif
                    </div>
                @endif

                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>
            </form>

        </div>
        <div id="login_br">
            <img src="http://47.93.81.30:81/img/login-bronze.png">
        </div>
    </div>
    </div>
@endsection
