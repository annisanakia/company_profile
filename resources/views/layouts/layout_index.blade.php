@php
    $layout = 'layouts.app_frontend';
@endphp

@extends($layout)
@section('content_app')
    @php
        $menuComposer = new \Lib\core\menuComposerFront();
        $menuComposer->compose();
    @endphp
	<div class="main-header w-100 position-relative overflow-hidden">
        <div class="wrapper-page">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand text-white" href="#">
                    <img src="{{ asset('assets/images/templates/ranchdeli-white.png') }}" class="pt-2" style="width:100px">
                </a>
                <button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                    @if(!is_array($menuComposer->compose()))
                        {!! $menuComposer->compose() !!}
                    @endif
                </div>
            </nav>
        </div>
        @yield('content_header')
    </div>
    @yield('content')
@endsection