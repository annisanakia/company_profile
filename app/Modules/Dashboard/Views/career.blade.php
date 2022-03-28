
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
            <div class="mb-2">
                <div class="line"></div>
                    <img src="{{ asset('assets/images/templates/tea-leaf.png') }}">
                <div class="line"></div>
            </div>
            <b class="color-green">AVAILABLE</b>
            <b class="color-orange">POSITIONS</b>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card w-100 border-0 h-100">
                    <div class="card-body border bg-white">
                        <div class="position-relative h-100">
                            <div class="card-title mb-0">
                                <h5 class="font-weight-bold">ENGINEERING AND TECHNOLOGY</h5>
                                <div class="subtitle"><i class="fa-solid fa-calendar mr-1"></i>25 Januari 2022 - 27 Januari 2022</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card w-100 border-0 h-100">
                    <div class="card-body border bg-white">
                        <div class="position-relative h-100">
                            <div class="card-title mb-0">
                                <h5 class="font-weight-bold">OPERATION</h5>
                                <div class="subtitle"><i class="fa-solid fa-calendar mr-1"></i>25 Januari 2022 - 27 Januari 2022</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card w-100 border-0 h-100">
                    <div class="card-body border bg-white">
                        <div class="position-relative h-100">
                            <div class="card-title mb-0">
                                <h5 class="font-weight-bold">ENGINEERING AND TECHNOLOGY</h5>
                                <div class="subtitle"><i class="fa-solid fa-calendar mr-1"></i>25 Januari 2022 - 27 Januari 2022</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card w-100 border-0 h-100">
                    <div class="card-body border bg-white">
                        <div class="position-relative h-100">
                            <div class="card-title mb-0">
                                <h5 class="font-weight-bold">OPERATION</h5>
                                <div class="subtitle"><i class="fa-solid fa-calendar mr-1"></i>25 Januari 2022 - 27 Januari 2022</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
            <a class="page-link" href="#">Next</a>
            </li>
        </ul>
        </nav>
    </div>
</section>
@endsection