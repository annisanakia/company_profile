<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php
        $logo = isset($company->logo)? asset($company->logo) : asset('assets/images/templates/ranchdeli.png');
        $name = isset($company)? $company->name : 'Hadijaya Solusi Pangan';
        $desc = isset($company->desc)? $company->desc : '';
        $favicon = asset(ucwords(strtolower($company->favicon)));
    ?>

    <meta name="description" content="{{ $desc }}">
    <meta name="author" content="{{ $name }}">

    <meta property="og:type" content="article">
    <meta property="og:site_name" content="{{ isset($company)? $company->code : 'HSP' }}">
    <meta property="og:title" content="{{ $name }}">
    <meta property="og:image" content="{{ $favicon }}">
    <meta property="og:description" content="{{ $desc }}">

    <title>{{$name}}</title>
    <link rel="icon" href="{{ $favicon }}">

    <!--  CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/slick/slick.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/slick/slick-theme.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/main_frontend.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/animated.css')}}">
    @yield('styles')

    <!--  JS -->
    <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/31c8d4e018.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/plugins/slick/slick.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('assets/js/angular.min.js')}}"></script>
    <script src="{{ asset('assets/js/main_frontend.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/main.js') }}" type="text/javascript"></script>
</head>
<body ng-app="myApp">
    @yield('content_app')
    @yield('scripts')
    <script type="text/javascript">
        var showApp = angular.module('myApp', []);
    </script>
    <script src="{{ asset('assets/js/tableAngular.js')}}" type="text/javascript"></script>
</body>
<footer class="section-footer">
    <section class="pt-4">
        <div class="wrapper-page container-fluid">
            <div class="row">
                <div class="col-lg-2 col-md-3 mb-4 d-flex align-items-center animated slideUp">
                    <img src="{{ $logo }}" style="width:100px"><br>
                </div>
                <div class="col-lg-4 col-md-9 mb-4 animated slideUp">
                    <span class="title pb-1 font-weight-bold">ABOUT US</span>
                    <div class="mt-4">
                        {{ $desc }}
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 animated slideUp">
                    <span class="title pb-1 font-weight-bold">CONTACT US</span>
                    <div class="mt-4">
                        <div class="m-2">
                            <i class="fa-solid fa-phone mr-1"></i>
                            {{ $company->phone_no }}
                        </div>
                        <div class="m-2">
                            <i class="fa-solid fa-envelope mr-1"></i>
                            {{ $company->email }}
                        </div>
                        <div class="m-2">
                            <i class="fa-solid fa-location-dot mr-1"></i>
                            {{ $company->address }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 animated slideUp">
                    <span class="title pb-1 font-weight-bold">SOCIAL MEDIA</span>
                    <div class="mt-4">
                        <ul class="nav">
                            @if($company->instagram != '')
                                <li class="nav-item text-center m-1 animated zoomIn d-3">
                                    <a href="{{ $company->instagram }}" target="_blank"><img src="{{ asset('assets/images/templates/instagram.png') }}"></a>
                                </li>
                            @endif
                            @if($company->facebook != '')
                                <li class="nav-item text-center m-1 animated zoomIn d-4">
                                    <a href="{{ $company->facebook }}" target="_blank"><img src="{{ asset('assets/images/templates/facebook.png') }}"></a>
                                </li>
                            @endif
                            @if($company->twitter != '')
                                <li class="nav-item text-center m-1 animated zoomIn d-5">
                                    <a href="{{ $company->twitter }}" target="_blank"><img src="{{ asset('assets/images/templates/twitter.png') }}"></a>
                                </li>
                            @endif
                            @if($company->whatsapp != '')
                                <li class="nav-item text-center m-1 animated zoomIn d-6">
                                    <a href="{{ $company->whatsapp }}" target="_blank"><img src="{{ asset('assets/images/templates/whatsapp.png') }}"></a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="text-center bg-dark text-white p-2">
        © 2022 {{ $name }}.
    </section
</footer>
</html>