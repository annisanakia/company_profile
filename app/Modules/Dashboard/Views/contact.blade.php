@extends('layouts.layout_frontend')

@section('content_header')
<section class="section-title position-relative text-white container-fluid">
    <div class="wrapper-page h-100 mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="animated slideUp d-3 mb-3 title pb-2"><span class="color-yellow">CONTACT US</h2>
            </div>
            <div class="col-md-6">
                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" placeholder="Enter name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email address</label>
                                <input name="email" type="email" class="form-control"  placeholder="Enter email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input name="phone_no" type="text" class="form-control" placeholder="Enter phone number">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Message</label>
                                <textarea name="message" class="form-control" placeholder="Enter your message" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn bg-light color-orange btn-submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div class="pb-2 text-center">
                    <section class="section-maps position-relative">
                        <div class="map" id="map"></div>
                    </section>
                </div>
            </div>
        </div>

        <div class="row justify-content-md-center m-3">
            <div class="text-center">
                <div class="col col-lg-2"></div>
                <div class="col align-self-center">
                    <div class="row mt-5">
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="rounded-circle bg-white square-medium mx-auto p-3 mb-3">
                                <h3><i class="fa-solid fa-phone color-orange"></i></h3>
                            </div>
                            +62 813-8080-1825
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="rounded-circle bg-white square-medium mx-auto p-3 mb-3">
                                <h3><i class="fa-solid fa-envelope color-orange"></i></h3>
                            </div>
                            hadijaya@gmail.com
                        </div>
                        <div class="col-lg-4 col-md-12 mb-4">
                            <div class="rounded-circle bg-white square-medium mx-auto p-3 mb-3">
                                <h3><i class="fa-solid fa-location-dot color-orange"></i></h3>
                            </div>
                            Jl. Raya Bojonggede - Kemang (Bomang), Jampang
                        </div>
                    </div>
                </div>
                <div class="col col-lg-2"></div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh4uXlaB7X5cIzENQoUxGEv1KFjkns6pw&callback=initMap&libraries=&v=weekly" async></script>
<script>
    // Initialize and add the map
    function initMap() {
        // The location of Uluru
        const uluru = { lat: -6.4757133, lng: 106.7317036};
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 17,
            center: uluru,
        });
        // The marker, positioned at Uluru
        const marker = new google.maps.Marker({
            position: uluru,
            map: map,
        });
    }
</script>
@endsection