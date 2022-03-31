@extends('layouts.layout_frontend')

@section('content_header')
<br>
@endsection

@section('content')
<section class="section-detail bg-light position-relative container-fluid">
    <div class="wrapper-page">
        <div class="row pt-4 mt-1">
            <div class="col-lg-8 mb-4">
                @if($data->photo != '')
                    <img class="img-header mt-3 mb-3 d-block" src="{{ asset($data->photo) }}">
                @else
                    <div class="img-header mt-3 mb-3 d-block d-flex align-items-center" style="background:#eee;height:300px">
                        <i class="fa-regular fa-image mx-auto" style="font-size: 70px;color: #cecece;"></i>
                    </div>
                @endif
                <div class="animated now slideUp d-3">
                    <div class="detail-title mb-3">
                        <h4 class="font-weight-bold mb-1">{{ $data->name }}</h4>
                        <span class="f-14">
                            {{ isset($data->date)? DateToDay($data->date) : '' }},
                            {{ isset($data->date)? DateToIndo($data->date) : '' }}
                        </span>
                    </div>
                    {!! $data->desc !!}
                </div>
            </div>
            <div class="col-lg-4">
                <div class="list-article">
                <h5 class="font-weight-bold mt-3 mb-3 animated now slideUp d-2">Artikel Terbaru</h5>
                <div class="form-group">
                {{-- <label class="font-weight-bold">Search</label>
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" placeholder="Search article" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary border" type="button" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                </div> --}}
                <div class="row">
                    @if(count($recents) <= 0)
                        <div class="col-md-12 border-bottom pb-2 mb-3">
                            NO DATA
                        </div>
                    @else
                        <?php
                            $d = 3;
                        ?>
                        @foreach($recents as $row)
                        <div class="col-md-12 border-bottom pb-2 mb-3 animated now zoomIn d-{{ $d++ }}">
                            <a href="{{ url('/read/article/'.getDateSlug($row->date).$row->slug.'.html') }}" class="text-decoration-none">
                                <span class="color-green font-weight-bold">{{ $row->name }}</span>
                                <br>
                                <span class="f-14">
                                    {{ isset($row->date)? DateToDay($row->date) : '' }},
                                    {{ isset($row->date)? DateToIndo($row->date) : '' }}
                                </span>
                            </a>
                        </div>
                        @endforeach
                    @endif
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection