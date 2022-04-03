@extends('layouts.layout_index')

@section('content_header')
<section class="section-carousel w-100 position-relative h-100">
    <div class="wrapper-page h-100">
        <div class="carousel-home h-100">
            @foreach($main_headers as $key => $data)
            <?php
                $data = isset($data->data_content)? $data->data_content : $data;
            ?>
            <div class="carousel-detail h-100" id="item_{{ $key }}">
                <div class="carousel-slide">
                    <img class="position-absolute piece piece1 d-none d-lg-inline-block" src="{{ asset('assets/images/templates/plate.png') }}" />
                    <img class="position-absolute piece piece2 d-none d-lg-inline-block" src="{{ asset('assets/images/templates/tray.png') }}" />
                </div>
                <div class="row align-items-lg-center w-100">
                    <div class="col-lg-6 text-center">
                        @if($data->photo != '')
                            <img class="img-header animated slideUp" src="{{ isset($data)? $data->photo : '' }}"/>
                        @else
                            <div class="img-header animated slideUp d-flex align-items-center" style="background:#eee">
                                <i class="fa-regular fa-image mx-auto" style="font-size: 120px;color: #cecece;"></i>
                            </div>
                        @endif
                        <br>
                    </div>
                    <div class="col-lg-6">
                        <div class="carousel-desc text-white animated slideUp">
                            <h2 class="d-3 mb-3 title d-inline-block pb-2">{{ isset($data)? $data->name : '' }}</h2>

                            <div class="desc-text d-4">
                                <p>
                                    {!! isset($data)? $data->desc : '' !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <br>
            <ul class="nav justify-content-center carousel-control carousel-dots">
                @foreach($main_headers as $key => $data)
                <li class="nav-item {{ $key == 0? 'active' : '' }} text-center pr-2">
                    <button type="button" class="dots_slider" data-id="{{ $key }}"></button>
                </li>
                @endforeach
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
                <div class="mb-2 animated slideUp d-3">
                    <div class="line"></div>
                        <img src="{{ asset('assets/images/templates/tea-leaf.png') }}">
                    <div class="line"></div>
                </div>
                <b class="color-green animated slideUp d-4">OUR</b>
                <b class="color-orange animated slideUp d-4">QUALITY</b>
            </div>
            <div class="row">
                <?php
                    $d = 3;
                ?>
                @foreach($company_qualitys as $data)
                <div class="col-lg-3 col-md-6 mx-auto">
                    <div class="panel-round mb-4 animated zoomIn d-{{ $d++ }}">
                        @if($data->photo != '')
                            <img class="mb-3" src="{{ asset($data->photo) }}">
                        @else
                            <div class="rounded-circle d-flex align-items-center mx-auto" style="background:#eee;width:160px;height:160px;">
                                <i class="fa-regular fa-image mx-auto" style="font-size: 50px;color: #cecece;"></i>
                            </div>
                        @endif
                        <br>
                        <div class="title color-green font-weight-bold mb-3">{{ $data->name }}</div>
                        {!! $data->desc !!}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<section class="section-client position-relative">
    <div class="wrapper-page">
        <ul class="nav justify-content-center container-fluid">
            <?php
                $d = 1;
            ?>
            @foreach($customers as $customer)
                @if($customer->photo != '')
                    <li class="nav-item text-center animated zoomIn d-{{ $d++ }}">
                        <img src="{{ asset($customer->photo) }}">
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</section>
<section class="section-product bg-white position-relative">
    <div class="wrapper-page">
        <div class="container-fluid w-100">
            <div class="title-section text-center">
                <div class="mb-2 animated slideUp d-3">
                    <div class="line"></div>
                        <img src="{{ asset('assets/images/templates/tea-leaf.png') }}">
                    <div class="line"></div>
                </div>
                <b class="color-green animated slideUp d-4">OUR</b>
                <b class="color-orange animated slideUp d-4">PRODUCT</b>
            </div>
            <div class="row pb-3">
                <?php
                    $d = 3;
                ?>
                @foreach($products as $product)
                <div class="col-lg-3 col-md-6 d-flex justify-content-center mb-3 mx-auto">
                    <div class="card w-100 position-relative animated zoomIn d-{{ $d++ }}">
                        @if($product->photo != '')
                            <img class="card-img-top img-header" src="{{ asset($product->photo) }}">
                        @else
                            <div class="card-img-top img-header d-flex align-items-center">
                                <i class="fa-regular fa-image mx-auto" style="font-size: 70px;color: #cecece;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="position-relative h-100 text-center">
                                <h6 class="card-title font-weight-bold mb-2">{{ $product->name }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center color-orange w-100 mb-4 animated slideUp d-3">
                <a href="{{ url('category/product.html') }}">SELENGKAPNYA<i class="ml-2 mt-1 fa-solid fa-angle-right"></i></a>
            </div>
        </div>
    </div>
</section>
<section class="section-customer position-relative bg-soft-orange">
    <div class="wrapper-page p-4">
        <div class="title-section text-center">
            <div class="mb-2 animated slideUp d-3">
                <div class="line"></div>
                    <img src="{{ asset('assets/images/templates/tea-leaf.png') }}">
                <div class="line"></div>
            </div>
            <b class="color-green animated slideUp d-4">OUR</b>
            <b class="color-orange animated slideUp d-4">CUSTOMER</b>
        </div>
        <div class="single-item">
        @foreach($testimonis as $data)
        <div class="desc animated slideUp d-5">
            @if($data->photo != '')
                <img class="rounded-circle d-inline-block" src="{{ asset($data->photo) }}" style="width:90px;height:90px;object-fit:cover">
            @else
                <div class="bg-orange rounded-circle d-inline-block p-3 text-center" style="width:90px;height:90px">
                    <img src="{{ asset('assets/images/templates/user.png') }}" style="width:50px" class="mx-auto">
                </div>
            @endif
            <h5 class="font-weight-bold mb-2 mt-4">{{ $data->name }}</h5>
            <div class="rating mb-4">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
            </div>
            {!! isset($data)? $data->desc : '' !!}
        </div>
        @endforeach
        </div>
    </div>
</section>
<section class="section-news bg-white position-relative container-fluid">
    <div class="wrapper-page w-100 pb-4">
        <div class="title-section text-center">
            <div class="mb-2 animated slideUp d-3">
                <div class="line"></div>
                    <img src="{{ asset('assets/images/templates/tea-leaf.png') }}">
                <div class="line"></div>
            </div>
            <b class="color-green animated slideUp d-4">COMPANY</b>
            <b class="color-orange animated slideUp d-4">ARTICLES</b>
        </div>
        <div class="row">
            <?php
                $d = 4;
            ?>
            @foreach($articles as $data)
                <div class="col-md-4 mb-4 mx-auto">
                    <div class="card w-100 border-0 h-100 animated slideUp d-{{ $d++ }}">
                        @if($data->photo != '')
                            <img class="card-img-top img-header" src="{{ asset($data->photo) }}">
                        @else
                            <div class="card-img-top img-header d-flex align-items-center" style="background:#eee">
                                <i class="fa-regular fa-image mx-auto" style="font-size: 70px;color: #cecece;"></i>
                            </div>
                        @endif
                        <div class="card-body border bg-white">
                            <div class="position-relative h-100 mb-4">
                                <div class="card-title mb-3">
                                    <h5 class="font-weight-bold">{{ $data->name }}</h5>
                                    <div class="subtitle"><i class="fa-solid fa-calendar mr-1"></i>{{ dateToIndo($data->date ) }}</div>
                                </div>
                                <p class="card-text pb-4 mb-0">
                                    {{ detailText($data->desc, 20) }}
                                </p>
                                <div class="card-btn position-absolute w-100 text-center">
                                    <a href="{{ url('/read/article/'.getDateSlug($data->date).$data->slug.'.html') }}" class="btn bg-orange text-white d-block">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
        function loopClasses() {
            var numItems = parseInt(($('.dots_slider').length)-1);
            var id = parseInt($('.carousel-dots li.active .dots_slider').attr('data-id'));
            var id_next = id+1;
            if(numItems == id){
                id_next = 0;
            }
            
            $('.carousel-dots li').removeClass('active');
            $('.carousel-home .carousel-detail').removeClass('active');

            $('.dots_slider[data-id="'+id_next+'"]').parent().addClass('active');
            $('#item_'+id_next).addClass('active');
        }
        setInterval(loopClasses, 10000);
        $('.single-item').slick({
            autoplay: true,
            arrows: false,
            autoplaySpeed: 5000
        });
    });
</script>
@endsection