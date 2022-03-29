@extends('layouts.app')
@section('content_app')

<div class="container-content">
    <div class="card m-1 mb-4">
        <div class="card-body p-md-4">
            <div class="row">
                <div class="col-md-6 p-md-3">
                    <h3 class="h3">Welcome Dashboard</h1>
                    <span class="fpx-14">Content Management System</span><br>
                    <span class="fpx-14">{{ Session()->get('company')? Session()->get('company')->name : '' }}</span>
                </div>
                <div class="col-md-6 text-center text-md-right pr-md-5">
                    <!-- <img class="img-dashboard" src="{{ asset('assets/images/tech.png') }}"> -->
                    <img class="img-dashboard" src="{{ Session()->get('company')? Session()->get('company')->logo : '' }}" style="width:200px"> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection