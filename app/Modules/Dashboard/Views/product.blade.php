@extends('layouts.layout_index')

@section('content_header')
<section class="section-title position-relative text-white h-100">
    <div class="wrapper-page container-fluid h-100">
        <div class="row align-items-lg-center mt-5 mb-5">
            <?php
                $product_header = isset($product_header->data_content)? $product_header->data_content : $product_header;
            ?>
            <div class="col-md-6">
                @if(isset($product_header->photo) && $product_header->photo != '')
                    <img class="img-header mb-3 animated slideUp" src="{{ isset($product_header)? $product_header->photo : '' }}"/>
                @else
                    <div class="img-header mb-3 animated slideUp d-flex align-items-center" style="background:#eee">
                        <i class="fa-regular fa-image mx-auto" style="font-size: 120px;color: #cecece;"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <h2 class="mb-3 title pb-2 animated slideUp d-3">
                    <span class="color-yellow">OUR PRODUCT</span><br>
                    {{ isset($profile_header)? $profile_header->name : '' }}
                </h2>
                <div class="animated slideUp d-4">
                    {!! isset($product_header)? $product_header->desc : '' !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<section class="section-product bg-white position-relative container-fluid">
    <div class="title-section text-center">
        <div class="mb-2 animated slideUp d-3">
            <div class="line"></div>
                <img src="{{ asset('assets/images/templates/tea-leaf.png') }}">
            <div class="line"></div>
        </div>
        <b class="color-green animated slideUp d-4">OUR</b>
        <b class="color-orange animated slideUp d-4">PRODUCT</b>
    </div>
    <div class="wrapper-page w-100 pb-4">
        <div class="row">
            <?php
                $d = 3;
            ?>
            @foreach($products as $data)
            <div class="col-lg-6 d-flex align-items-stretch mx-auto">
                <div class="bg-light panel mb-5 border animated slideUp d-{{ $d++ }}">
                    <div class="row h-100">
                        <div class="col-md-5">
                            <img class="w-100 h-100 border-right object-cover" src="{{ asset('assets/images/templates/chicken-drumsticks.jpeg') }}">
                        </div>
                        <div class="col-md-7 p-4">
                            <h3 class="color-orange mb-2">{{ $data->name }}</h3>
                            {!! $data->desc !!}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $products->appends($param)->links('component.pagination')}}
        <span class="result-count mx-auto animated slideUp d-3">Showing {{$products->firstItem()}} to {{$products->lastItem()}} of {{$products->total()}} entries</span>
    </div>
</section>
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
@endsection