@extends('layouts.layout')

@section('content')

<div class="card">
<div class="card-body">
    <div class="title-form">
        {{$title_form}}
    </div>
    <div class="block-form">
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td>{{ isset($data->name)? $data->name : '' }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>{{ isset($data->email)? $data->email : '' }}</td>
                        </tr>
                        <tr>
                            <td>Phone Number</td>
                            <td>:</td>
                            <td>{{ isset($data->phone_no)? $data->phone_no : '' }}</td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td>:</td>
                            <td>{{ isset($data->date)? dateToIndo($data->date) : '' }}</td>
                        </tr>
                        <tr>
                            <td>Message</td>
                            <td>:</td>
                            <td>{!! isset($data->desc)? $data->desc : '' !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @include('component.actions')
    </div>
</div>
</div>
@endsection