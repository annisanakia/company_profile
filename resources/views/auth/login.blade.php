<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <?php
            $title = 'PINTRO';
        ?>

        <link rel="icon" href="{{ asset('assets/images/templates/favicon.png') }}">
        <title>{{$title}}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/font-awesome/css/all.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/icheck/skins/minimal/_all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/main.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/login.css')}}">
    </head> 
    <body class="bg-orange h-100">
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-lg-6 mx-auto">
                    <div class="login-panel mx-auto">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <img class="login-logo" src="{{ asset('assets/images/logo.png')}}" alt="branding logo">
                                <div class="login-title">
                                    Sign In
                                </div>
                            </div>
                            <div class="col-md-12">
                                <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="login-form">
                                    <div class="form-field {{ $errors->has('username') ? ' is-invalid' : '' }}">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-center">
                                                    <i class="fas fa-user-circle"></i>
                                                </span>
                                            </div>
                                            <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}"  placeholder="Username" autofocus>
                                        </div>
                                        @if ($errors->has('username'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-field {{ $errors->has('password') ? ' is-invalid' : '' }}">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-key"></i>
                                                </span>
                                            </div>
                                            <input id="password" type="password" class="form-control border-right-0" name="password" placeholder="Password">
                                            <div class="input-group-append">
                                                <button class="btn" type="button" id="btn-pw">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-login mt-4 mb-3 btn-success btn-lg btn-block" type>LOGIN</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/plugins/icheck/icheck.js') }}"></script>
        <script type='text/javascript'>
            $(document).ready(function(){
                $('.iCheck').iCheck({
                    checkboxClass: 'icheckbox_minimal-green',
                    radioClass: 'iradio_minimal-green'
                });
                $('#btn-pw').mouseup(function(){
                    $('#password').attr('type', 'password');
                });
                $('#btn-pw').on({ 'touchend' : function(){
                    $('#password').attr('type', 'password');
                } });
                $('#btn-pw').mousedown(function(){
                    $('#password').attr('type', 'text');
                });
                $('#btn-pw').on({ 'touchstart' : function(){
                    $('#password').attr('type', 'text');
                } });
            });
        </script>
    </body>
</html>