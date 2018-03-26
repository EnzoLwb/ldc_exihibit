@extends('layouts.public')

@section('title', '注册')

@section('body')
    <div class="middle-box text-center loginscreen">
        <div>
            <h3>欢迎注册</h3>
            <p>创建一个新账户</p>
            <form class="m-t" role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" placeholder="请输入用户名" required="" name="username" value="{{ old('username') }}" />
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" placeholder="请输入邮箱" required="" name="email" value="{{ old('email') }}" />
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" placeholder="请输入手机" required="" name="phone" value="{{ old('phone') }}" />
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" placeholder="请输入密码" required="" name="password" />
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" placeholder="请再次输入密码" required="" name="password_confirmation" />
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                @if ($captchaRegister)
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
                <div class="checkbox text-left">
                    <label>
                        <input type="checkbox"> 我同意注册协议
                    </label>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">注 册</button>

                <p class="text-muted text-center">
                    已经有账户了？
                    <a href="{{ url('/login') }}">点此登录</a>
                </p>

            </form>
        </div>
    </div>
@endsection
