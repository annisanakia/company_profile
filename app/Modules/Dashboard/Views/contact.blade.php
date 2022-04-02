@extends('layouts.layout_frontend')

@section('content_header')
<style>
    .btn-submit{
        background-color: #fff;
        color:#f15929;
        border:1px solid #fff
    }
    .btn-submit:hover{
        background-color: #dae0e5!important;
        color:#f15929
    }
</style>
<section class="section-title position-relative text-white container-fluid">
    <div class="wrapper-page h-100 mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="animated slideUp d-3 mb-3 title pb-2"><span class="color-yellow">CONTACT US</h2>
            </div>
            <div class="col-md-6 animated slideUp d-2">
                {{ Form::open(array('route' => 'dashboard.storeContact', 'class'=>'form-validation', 'method'=>'POST')) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group <?php if ($errors->has('name')) echo 'has-error' ?>">
                                {{ Form::label('Name', 'Name', array('class'=>'control-label')) }}
                                {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Enter name')) }}
                                {!!$errors->first('name', ' <span class="form-text error">:message</span>')!!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group <?php if ($errors->has('email')) echo 'has-error' ?>">
                                {{ Form::label('Email address', 'Email address', array('class'=>'control-label')) }}
                                {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Enter email')) }}
                                {!!$errors->first('email', ' <span class="form-text error">:message</span>')!!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group <?php if ($errors->has('phone_no')) echo 'has-error' ?>">
                                {{ Form::label('Phone Number', 'Phone Number', array('class'=>'control-label')) }}
                                {{ Form::text('phone_no', null, array('class'=>'form-control', 'placeholder'=>'Enter Phone Number')) }}
                                {!!$errors->first('phone_no', ' <span class="form-text error">:message</span>')!!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group <?php if ($errors->has('desc')) echo 'has-error' ?>">
                                {{ Form::label('Message', 'Message', array('class'=>'control-label')) }}
                                {{ Form::textarea('desc', null, array('class'=>'form-control', 'placeholder'=>'Enter your message', 'rows'=>4)) }}
                                {!!$errors->first('desc', ' <span class="form-text error">:message</span>')!!}
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn color-orange btn-submit">Submit</button>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
            <div class="col-md-6">
                <div class="pb-2 text-center animated slideUp d-2">
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
                        <div class="col-lg-4 col-md-6 mb-4 animated slideUp d-3">
                            <div class="rounded-circle bg-white square-medium mx-auto p-3 mb-3">
                                <h3><i class="fa-solid fa-phone color-orange"></i></h3>
                            </div>
                            {{ $company->phone_no }}
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4 animated slideUp d-4">
                            <div class="rounded-circle bg-white square-medium mx-auto p-3 mb-3">
                                <h3><i class="fa-solid fa-envelope color-orange"></i></h3>
                            </div>
                            {{ $company->email }}
                        </div>
                        <div class="col-lg-4 col-md-12 mb-4 animated slideUp d-5">
                            <div class="rounded-circle bg-white square-medium mx-auto p-3 mb-3">
                                <h3><i class="fa-solid fa-location-dot color-orange"></i></h3>
                            </div>
                            {{ $company->address }}
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