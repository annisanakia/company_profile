
@extends('layouts.layout_frontend')

@section('content_header')
<section class="section-title position-relative text-white container-fluid">
    <div class="wrapper-page h-100 mt-5 mb-5">
        <h2 class="animated now slideUp d-3 mb-3 title pb-3"><span class="color-yellow">OUR NEWS</h2>
    </div>
</section>
@endsection

@section('content')
<section class="section-news list bg-light position-relative container-fluid">
    <div class="wrapper-page w-100 pb-4">
        <div class="title-section text-center">
            <div class="mb-2 animated now slideUp d-3">
                <div class="line"></div>
                    <img src="{{ asset('assets/images/templates/tea-leaf.png') }}">
                <div class="line"></div>
            </div>
            <b class="color-green animated now slideUp d-4">COMPANY</b>
            <b class="color-orange animated now slideUp d-4">ARTICLES</b>
        </div>
        <div class="row">
            @foreach($articles as $data)
            <div class="col-md-4 mb-4">
                <div class="card w-100 border-0 h-100 animated now slideUp d-8">
                    <img class="card-img-top img-header" src="{{ asset('assets/images/templates/pasar-ayam.jpeg') }}">
                    <div class="card-body border bg-white">
                        <div class="position-relative h-100 mb-4">
                            <div class="card-title mb-3">
                                <h5 class="font-weight-bold">{{ $data->name }}</h5>
                                <div class="subtitle"><i class="fa-solid fa-calendar mr-1"></i>{{ dateToIndo($data->date) }}</div>
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
        {{ $articles->appends($param)->links('component.pagination')}}
        <span class="result-count mx-auto animated slideUp d-3">Showing {{$articles->firstItem()}} to {{$articles->lastItem()}} of {{$articles->total()}} entries</span>
    </div>
</section>
<script type="text/javascript">
</script>
@endsection