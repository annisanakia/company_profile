
@extends('layouts.layout_frontend')

@section('content_header')
<section class="section-title position-relative text-white container-fluid">
    <div class="wrapper-page h-100 mt-5 mb-5">
        <h2 class="animated slideUp d-3 mb-3 title pb-3"><span class="color-yellow">CAREER WITH US</h2>
    </div>
</section>
@endsection

@section('content')
<section class="section-career list bg-light position-relative container-fluid">
    <div class="wrapper-page w-100 pb-4">
        <div class="title-section text-center">
            <div class="mb-2 animated now slideUp d-3">
                <div class="line"></div>
                    <img src="{{ asset('assets/images/templates/tea-leaf.png') }}">
                <div class="line"></div>
            </div>
            <b class="color-green animated now slideUp d-4">AVAILABLE</b>
            <b class="color-orange animated now slideUp d-4">POSITIONS</b>
        </div>
        <div class="row">
            @foreach($datas as $data)
            <div class="col-md-6 mb-4 mx-auto">
                <a class="card w-100 border-0 h-100 text-decoration-none" href="#">
                    <div class="card-body border bg-white">
                        <div class="position-relative h-100">
                            <div class="card-title mb-0">
                                <h5 class="font-weight-bold">{{ $data->name }}</h5>
                                <div class="subtitle"><i class="fa-solid fa-calendar mr-1"></i>{{ dateToIndo($data->start_date) }} - {{ dateToIndo($data->end_date) }}</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        {{ $datas->appends($param)->links('component.pagination')}}
        <span class="result-count mx-auto animated now slideUp d-3">Showing {{$datas->firstItem()}} to {{$datas->lastItem()}} of {{$datas->total()}} entries</span>
    </div>
</section>
@endsection