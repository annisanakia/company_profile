@extends('layouts.layout_index')

@section('content_header')
<section class="section-carousel w-100 position-relative h-100">
    <div class="wrapper-page h-100">
        <div class="carousel-home h-100">
            <div class="carousel-detail h-100" id="item_0">
                <div class="carousel-slide">
                    <img class="position-absolute piece piece1 d-none d-lg-inline-block" src="{{ asset('assets/images/templates/plate.png') }}" />
                    <img class="position-absolute piece piece2 d-none d-lg-inline-block" src="{{ asset('assets/images/templates/tray.png') }}" />
                </div>
                <div class="row align-items-lg-center">
                    <div class="col-lg-6 text-center">
                        <img class="img-header animated slideUp" src="{{ asset('assets/images/templates/raw-chicken.jpeg') }}"/><br>
                    </div>
                    <div class="col-lg-6">
                        <div class="carousel-desc text-white animated slideUp">
                            <h2 class="d-3 mb-3 title d-inline-block pb-2">LOREM IPSUM</h2>

                            <div class="desc-text d-4">
                                <p>
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                    when an unknown printer took a galley of type and scrambled it to make a type
                                    specimen book. It has survived not only five centuries, but also the leap into
                                    electronic typesetting, remaining essentially unchanged.
                                </p>
                                <a href="#" class="btn btn-orange">Contact US</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-detail h-100" id="item_1">
                <div class="carousel-slide">
                    <img class="position-absolute piece piece1 d-none d-lg-inline-block" src="{{ asset('assets/images/templates/plate.png') }}" />
                    <img class="position-absolute piece piece2 d-none d-lg-inline-block" src="{{ asset('assets/images/templates/tray.png') }}" />
                </div>
                <div class="row align-items-lg-center">
                    <div class="col-lg-6 text-center">
                        <img class="img-header animated slideUp" src="{{ asset('assets/images/templates/company-people.jpg') }}"/><br>
                    </div>
                    <div class="col-lg-6">
                        <div class="carousel-desc text-white animated slideUp">
                            <h2 class="d-3 mb-3 title d-inline-block pb-2">GALLERY OF TYPE</h2>

                            <div class="desc-text d-4">
                                <p>
                                    It has survived not only five centuries, but also the leap into
                                    electronic typesetting, remaining essentially unchanged.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <ul class="nav justify-content-center carousel-control carousel-dots">
                <li class="nav-item active text-center pr-2">
                    <button type="button" class="dots_slider" data-id="0"></button>
                </li>
                <li class="nav-item text-center pr-2">
                    <button type="button" class="dots_slider" data-id="1"></button>
                </li>
                <li class="nav-item text-center dots_slider pr-2">
                    <button type="button" class="dots_slider" data-id="2"></button>
                </li>
            </ul>
        </div>
    </div>
</section>
@endsection

@section('content')
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
<section class="section-client position-relative">
    <div class="wrapper-page">
        <ul class="nav justify-content-center container-fluid">
            <li class="nav-item text-center">
                <img src="{{ asset('assets/images/templates/kfc.png') }}">
            </li>
            <li class="nav-item text-center">
                <img src="{{ asset('assets/images/templates/mcd.png') }}">
            </li>
        </ul>
    </div>
</section>
<section class="section-product bg-white position-relative">
    <div class="wrapper-page">
        <div class="container-fluid w-100">
            <div class="title-section text-center">
                <div class="mb-2">
                    <div class="line"></div>
                        <img src="{{ asset('assets/images/templates/tea-leaf.png') }}">
                    <div class="line"></div>
                </div>
                <b class="color-green">OUR</b>
                <b class="color-orange">PRODUCT</b>
            </div>
            <div class="row pb-3">
                <div class="col-lg-3 col-md-6 d-flex justify-content-center mb-3">
                    <div class="card w-100">
                        <img class="card-img-top img-header" src="{{ asset('assets/images/templates/chicken-drumsticks.jpeg') }}">
                        <div class="card-body">
                            <div class="position-relative h-100 text-center">
                                <h6 class="card-title font-weight-bold mb-2">AYAM PAHA BAWAH</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex justify-content-center mb-3">
                    <div class="card w-100 position-relative">
                        <img class="card-img-top img-header" src="{{ asset('assets/images/templates/chicken-wings.jpeg') }}">
                        <div class="card-body">
                            <div class="position-relative h-100 text-center">
                                <h6 class="card-title font-weight-bold mb-2">AYAM SAYAP</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex justify-content-center mb-3">
                    <div class="card w-100 position-relative">
                        <img class="card-img-top img-header" src="{{ asset('assets/images/templates/chicken.jpeg') }}">
                        <div class="card-body">
                            <div class="position-relative h-100 text-center">
                                <h6 class="card-title font-weight-bold mb-2">AYAM UTUH</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex justify-content-center mb-3">
                    <div class="card w-100 position-relative">
                        <img class="card-img-top img-header" src="{{ asset('assets/images/templates/chicken-breast.jpeg') }}">
                        <div class="card-body">
                            <div class="position-relative h-100 text-center">
                                <h6 class="card-title font-weight-bold mb-2">AYAM DADA</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center color-orange w-100 mb-4">
                <a href="#">SELENGKAPNYA<i class="ml-2 mt-1 fa-solid fa-angle-right"></i></a>
            </div>
        </div>
    </div>
</section>
<section class="section-customer position-relative bg-soft-orange">
    <div class="wrapper-page p-4">
        <div class="title-section text-center">
            <div class="mb-2">
                <div class="line"></div>
                    <img src="{{ asset('assets/images/templates/tea-leaf.png') }}">
                <div class="line"></div>
            </div>
            <b class="color-green">OUR</b>
            <b class="color-orange">CUSTOMER</b>
        </div>
        <div class="desc">
            <div class="bg-orange rounded-circle d-inline-block p-3" style="width:90px;height:90px">
                <img src="{{ asset('assets/images/templates/user.png') }}" style="width:50px">
            </div>
            <h5 class="font-weight-bold mb-2 mt-4">LOREM IPSUM</h5>
            <div class="rating mb-4">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
            </div>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry.<br>
            Lorem Ipsum has been the industry's standard dummy
        </div>
    </div>
</section>
<section class="section-news bg-white position-relative container-fluid">
    <div class="wrapper-page w-100 pb-4">
        <div class="title-section text-center">
            <div class="mb-2">
                <div class="line"></div>
                    <img src="{{ asset('assets/images/templates/tea-leaf.png') }}">
                <div class="line"></div>
            </div>
            <b class="color-green">COMPANY</b>
            <b class="color-orange">ARTICLES</b>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card w-100 border-0 h-100">
                    <img class="card-img-top img-header" src="{{ asset('assets/images/templates/pasar-ayam.jpeg') }}">
                    <div class="card-body border bg-white">
                        <div class="position-relative h-100 mb-4">
                            <div class="card-title mb-3">
                                <h5 class="font-weight-bold">AYAM BERKUALITAS</h5>
                                <div class="subtitle"><i class="fa-solid fa-calendar mr-1"></i>25 Januari 2022</div>
                            </div>
                            <p class="card-text pb-4 mb-0">
                                Some quick example text to build on the card title and make up the bulk of the card's content ...
                            </p>
                            <div class="card-btn position-absolute w-100 text-center">
                                <a href="#" class="btn bg-orange text-white d-block">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card w-100 border-0 h-100">
                    <img class="card-img-top img-header" src="{{ asset('assets/images/templates/karyawan.jpg') }}">
                    <div class="card-body border bg-white">
                        <div class="position-relative h-100 mb-4">
                            <div class="card-title mb-3">
                                <h5 class="font-weight-bold">AYAM PAHA BAWAH</h5>
                                <div class="subtitle"><i class="fa-solid fa-calendar mr-1"></i>25 Januari 2022</div>
                            </div>
                            <p class="card-text pb-4 mb-0">
                                Some quick example text to build on the card title and make up the bulk of the card's content ...
                            </p>
                            <div class="card-btn position-absolute w-100 text-center">
                                <a href="#" class="btn bg-orange text-white d-block">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card w-100 border-0 h-100">
                    <img class="card-img-top img-header" src="{{ asset('assets/images/templates/bakti-sosial.jpeg') }}">
                    <div class="card-body border bg-white">
                        <div class="position-relative h-100 mb-4">
                            <div class="card-title mb-3">
                                <h5 class="font-weight-bold">BAKTI SOSIAL HADIJAYA SOLUSI PANGAN</h5>
                                <div class="subtitle"><i class="fa-solid fa-calendar mr-1"></i> 25 Januari 2022</div>
                            </div>
                            <p class="card-text pb-4 mb-0">
                                Some quick example text to build on the card title and make up the bulk of the card's content ...
                            </p>
                            <div class="card-btn position-absolute w-100 text-center">
                                <a href="#" class="btn bg-orange text-white d-block">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        $('#item_0').addClass('active');
        $('.dots_slider').click(function (e) {
            var id = $(this).attr('data-id');
            $('.carousel-dots li').removeClass('active');
            $('.carousel-home .carousel-detail').removeClass('active');

            $(this).parent().addClass('active');
            $('#item_'+id).addClass('active');
        });
    });
</script>
@endsection