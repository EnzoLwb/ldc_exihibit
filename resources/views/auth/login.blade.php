@extends('layouts.public')

@section('title', '登录')

@section('body')
    <div class="middle-box text-center loginscreen">
        <div>
            <h3>欢迎</h3>

            <form class="m-t" role="form" method="POST" action="{{ url('/login') }}">
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
                @if ($captchaLogin)
                <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                    <input type="text" name="captcha" class="form-control" placeholder="验证码" required="" style="width: 150px; float: left;" />
                    <img src="{{ url('cpt/show') }}" onclick="this.src='{{ url('cpt/show') }}?r=' + Math.random();" title="看不清，换一个" style="cursor:pointer;"/>
                    @if ($errors->has('captcha'))
                        <span class="help-block">
                            <strong>{{ $errors->first('captcha') }}</strong>
                        </span>
                    @endif
                </div>
                @endif

                <div class="form-group">
                    <input type="checkbox" name="remember"> Remember Me
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>

                <p class="text-muted text-center">
                    <a href="{{ url('/password/reset') }}">忘记密码了？</a>
                    | <a href="{{ url('/register') }}">注册一个新账号</a>
                </p>

            </form>
        </div>
    </div>
@endsection
