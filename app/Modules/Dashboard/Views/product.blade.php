@extends('layouts.layout_frontend')

@section('content_header')
<section class="section-title position-relative text-white h-100">
    <div class="wrapper-page container-fluid h-100">
        <div class="row align-items-lg-center mt-5 mb-5">
            <div class="col-md-6">
                <img class="img-header mb-3" src="{{ asset('assets/images/templates/chicken-raw.webp') }}"/>
            </div>
            <div class="col-md-6">
                <h2 class="mb-3 title pb-2"><span class="color-yellow">OUR PRODUCT</span><br>HADIJAYA SOLUSI PANGAN</h2>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                software like Aldus PageMaker including versions of Lorem Ipsum.
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<section class="section-product bg-white position-relative container-fluid">
    <div class="title-section text-center">
        <div class="mb-2">
            <div class="line"></div>
                <img src="assets/images/tea-leaf.png">
            <div class="line"></div>
        </div>
        <b class="color-green">OUR</b>
        <b class="color-orange">PRODUCT</b>
    </div>
    <div class="wrapper-page w-100 pb-4">
        <div class="row">
            <div class="col-lg-6 d-flex align-items-stretch">
                <div class="bg-light panel mb-5 border">
                    <div class="row h-100">
                        <div class="col-md-5">
                            <img class="w-100 h-100 border-right object-cover" src="{{ asset('assets/images/templates/chicken-drumsticks.jpeg') }}">
                        </div>
                        <div class="col-md-7 p-4">
                            <h3 class="color-orange mb-2">AYAM PAHA BAWAH</h3>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                            when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-stretch">
                <div class="bg-light panel mb-5 border">
                    <div class="row h-100">
                        <div class="col-md-5">
                            <img class="w-100 h-100 border-right object-cover" src="{{ asset('assets/images/templates/chicken-wings.jpeg') }}">
                        </div>
                        <div class="col-md-7 p-4">
                            <h3 class="color-orange mb-2">AYAM SAYAP</h3>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-stretch">
                <div class="bg-light panel mb-5 border">
                    <div class="row h-100">
                        <div class="col-md-5">
                            <img class="w-100 h-100 border-right object-cover" src="{{ asset('assets/images/templates/chicken.jpeg') }}">
                        </div>
                        <div class="col-md-7 p-4">
                            <h3 class="color-orange mb-2">AYAM UTUH</h3>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-stretch">
                <div class="bg-light panel mb-5 border">
                    <div class="row h-100">
                        <div class="col-md-5">
                            <img class="w-100 h-100 border-right object-cover" src="{{ asset('assets/images/templates/chicken-breast.jpeg') }}">
                        </div>
                        <div class="col-md-7 p-4">
                            <h3 class="color-orange mb-2">AYAM DADA</h3>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-quality position-relative bg-white">
    <img class="bg" src="{{ asset('assets/images/templates/bg-food.jpg') }}">
    <div class="wrapper-page">
        <div class="desc text-center container-fluid w-100 position-relative">
            <div class="title-section">
                <div class="mb-2">
                    <div class="line"></div>
                        <img src="{{ asset('assets/images/templates/tea-leaf.png') }}">
                    <div class="line"></div>
                </div>
                <b class="color-green">OUR</b>
                <b class="color-orange">QUALITY</b>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel-round mb-4">
                        <img class="mb-3" src="{{ asset('assets/images/templates/raw-chicken2.jpeg') }}"><br>
                        <div class="title color-green font-weight-bold mb-3">GOOD QUALITY</div>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel-round mb-4">
                        <img class="mb-3" src="{{ asset('assets/images/templates/customer-service.webp') }}"><br>
                        <div class="title color-green font-weight-bold mb-3">SERVICE QUALITY</div>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel-round mb-4">
                        <img class="mb-3" src="{{ asset('assets/images/templates/delivery.jpeg') }}"><br>
                        <div class="title color-green font-weight-bold mb-3">DELIVERY QUALITY</div>
                        Lorem Ipsum is simply dummy text of the printing.
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel-round mb-4">
                        <img class="mb-3" src="{{ asset('assets/images/templates/thumbs-up.jpeg') }}"><br>
                        <div class="title color-green font-weight-bold mb-3">RESPONSIVENESS</div>
                        It has survived not only five centuries, but also the leap into electronic typesetting,
                        remaining essentially.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection