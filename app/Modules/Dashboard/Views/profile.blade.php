@extends('layouts.layout_frontend')

@section('content_header')
<section class="section-title position-relative text-white h-100">
    <div class="wrapper-page container-fluid h-100">
        <div class="row align-items-lg-center mt-5 mb-5">
            <div class="col-md-6">
                <h2 class="animated slideUp d-3 mb-3 title pb-2"><span class="color-yellow">PROFILE</span><br>HADIJAYA SOLUSI PANGAN</h2>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                software like Aldus PageMaker including versions of Lorem Ipsum.
            </div>
            <div class="col-md-6">
                <img class="img-header" src="{{ asset('assets/images/templates/company-people.jpg') }}"/>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<section class="section-reason bg-light position-relative">
    <div class="wrapper-page container-fluid">
        <div class="row align-items-lg-center pt-5 pb-5">
            <div class="col-md-6 p-4">
                <ul class="list-group">
                    <li class="list-group-item active">Cras justo odio</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Morbi leo risus</li>
                    <li class="list-group-item">Morbi leo risus</li>
                </ul>
            </div>
            <div class="col-md-6 p-4">
                <h3 class="title pb-1 font-weight-bold color-orange"><span class="color-green">WHY</span> HADIJAYA?</h3>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting
            </div>
        </div>
    </div>
</section>
<section class="section-visi bg-light position-relative">
    <div class="wrapper-page container-fluid">
        <div class="bg-softgray panel-visi">
            <div class="row align-items-lg-center p-5">
                <div class="col-lg-6 text-justify">
                    <h3>VISI</h3>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    <br>
                    <h3 class="mt-4">MISI</h3>
                    <ul>
                        <li>It has survived not only five centuries, but also the leap into electronic typesetting</li>
                        <li>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</li>
                        <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry</li>
                    </ul>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('assets/images/templates/chicken-raw.webp') }}" class="image rounded">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-team bg-light position-relative container-fluid">
    <div class="wrapper-page">
        <div class="title-section text-center">
            <div class="mb-2">
                <div class="line"></div>
                    <img src="{{ asset('assets/images/templates/tea-leaf.png') }}">
                <div class="line"></div>
            </div>
            <b class="color-green">OUR</b>
            <b class="color-orange">TEAM</b>
        </div>
        <div class="position-relative mb-5">
            <div class="carousel-slide">
                <img src="{{ asset('assets/images/templates/manager.jpeg') }}" class="border img-slide">
                <div class="panel-slide text-white d-flex align-items-center">
                    <div class="bg-orange h-100 w-100 p-5">
                        <h2 class="pb-2">LOREM IPSUM HARYANTO</h2>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                        when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    </div>
                </div>
            </div>
            <div class="position-absolute carousel-control text-white">
                <div class="d-flex">
                    <div class="bg-orange p-2 pr-3 pl-3"><i class="fa-solid fa-chevron-left"></i></div>
                    <div class="bg-orange p-2 pr-3 pl-3"><i class="fa-solid fa-chevron-right"></i></div>
                </div>
            </div>
        </div>
        <br>
    </div>
</section>
@endsection