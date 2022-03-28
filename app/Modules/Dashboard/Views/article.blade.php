
@extends('layouts.layout_frontend')

@section('content_header')
<section class="section-title position-relative text-white container-fluid">
    <div class="wrapper-page h-100 mt-5 mb-5">
        <h2 class="animated slideUp d-3 mb-3 title pb-3"><span class="color-yellow">OUR NEWS</h2>
    </div>
</section>
@endsection

@section('content')
<section class="section-news list bg-light position-relative container-fluid">
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
                                <a href="news_detail.php" class="btn bg-orange text-white d-block">Selengkapnya</a>
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
                                <a href="news_detail.php" class="btn bg-orange text-white d-block">Selengkapnya</a>
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
                                <a href="news_detail.php" class="btn bg-orange text-white d-block">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                <a href="news_detail.php" class="btn bg-orange text-white d-block">Selengkapnya</a>
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
                                <a href="news_detail.php" class="btn bg-orange text-white d-block">Selengkapnya</a>
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
        <!-- <nav aria-label="Page navigation example">
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
        </nav> -->
    </div>
</section>
@endsection