<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Company Profile</title>

    <!--  CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/main_frontend.css')}}">
    @yield('styles')

    <!--  JS -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/31c8d4e018.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/main.js') }}" type="text/javascript"></script>
</head>
<body>
    @yield('content_app')
    @yield('scripts')
</body>
<footer class="section-footer">
    <section class="pt-4">
        <div class="wrapper-page container-fluid">
            <div class="row">
                <div class="col-lg-2 col-md-3 mb-4 d-flex align-items-center">
                    <img src="{{ asset('assets/images/templates/ranchdeli.png') }}" style="width:100px"><br>
                </div>
                <div class="col-lg-4 col-md-9 mb-4">
                    <span class="title pb-1 font-weight-bold">ABOUT US</span>
                    <div class="mt-4">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer
                        took a galley of type and scrambled it to make a type specimen book.
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <span class="title pb-1 font-weight-bold">CONTACT US</span>
                    <div class="mt-4">
                        <div class="m-2">
                            <i class="fa-solid fa-phone mr-1"></i>
                            +62 813-8080-1825
                        </div>
                        <div class="m-2">
                            <i class="fa-solid fa-envelope mr-1"></i>
                            hadijaya@gmail.com
                        </div>
                        <div class="m-2">
                            <i class="fa-solid fa-location-dot mr-1"></i>
                            Jl. Raya Bojonggede - Kemang (Bomang), Jampang, Kec. Kemang, Kabupaten Bogor, Jawa Barat 16310
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <span class="title pb-1 font-weight-bold">SOCIAL MEDIA</span>
                    <div class="mt-4">
                        <ul class="nav">
                            <li class="nav-item text-center m-1">
                                <a href="#"><img src="{{ asset('assets/images/templates/instagram.png') }}"></a>
                            </li>
                            <li class="nav-item text-center m-1">
                                <a href="#"><img src="{{ asset('assets/images/templates/facebook.png') }}"></a>
                            </li>
                            <li class="nav-item text-center m-1">
                                <a href="#"><img src="{{ asset('assets/images/templates/twitter.png') }}"></a>
                            </li>
                            <li class="nav-item text-center m-1">
                                <a href="#"><img src="{{ asset('assets/images/templates/whatsapp.png') }}"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="text-center bg-dark text-white p-2">
        © 2022 Hadijaya Solusi Pangan.
    </section>
</footer>
</html>