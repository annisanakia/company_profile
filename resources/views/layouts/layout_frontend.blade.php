@php
    $layout = 'layouts.app_frontend';
@endphp

@extends($layout)
@section('content_app')
    @php
        $menuComposer = new \Lib\core\menuComposer();
        $menucontent = $menuComposer->compose2();
        $segment = $menuComposer->getSegment();
    @endphp
	<div class="main-header height-auto w-100 position-relative overflow-hidden">
        <div class="wrapper-page">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand text-white" href="#">
                    <img src="{{ asset('assets/images/templates/ranchdeli-white.png') }}" class="pt-2" style="width:100px">
                </a>
                <button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item text-center active">
                            <a class="nav-link" href="index.php">HOME <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" href="profile.php">PROFILE</a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" href="news.php">NEWS</a>
                        </li>
                        <li class="nav-item text-center dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                PRODUCT
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="product.php">Action</a>
                            <a class="dropdown-item" href="product.php">Another action</a>
                            <a class="dropdown-item" href="product.php">Something else here</a>
                            </div>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" href="career.php">CAREER</a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" href="contact.php">CONTACT</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        @yield('content_header')
    </div>
    @yield('content')
@endsection