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
                            <td width="150px">Career Type</td>
                            <td>:</td>
                            <td>{{ isset($data->career_type->name)? $data->career_type->name : '' }}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td>{{ isset($data->name)? $data->name : '' }}</td>
                        </tr>
                        <tr>
                            <td>Date Job Vacancy</td>
                            <td>:</td>
                            <td>
                                {{ isset($data->start_date)? dateToIndo($data->start_date) : 'NA' }} -
                                {{ isset($data->end_date)? dateToIndo($data->end_date) : 'NA' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Status Publish</td>
                            <td>:</td>
                            <td>{{ $data->is_publish == 1? 'Publish' : 'Draft' }}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>:</td>
                            <td>{!! isset($data->desc)? $data->desc : '' !!}</td>
                        </tr>
                        <tr>
                            <td>Qualification</td>
                            <td>:</td>
                            <td>{!! isset($data->qualification)? $data->qualification : '' !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                        <tr>
                            <td width="150px">Photo Product</td>
                            <td>:</td>
                            <td>
                                @if(isset($data->photo) && $data->photo != '')
                                    <div class="fileinput-preview img-thumbnail text-center" data-trigger="fileinput" style="width: 135px; height: 150px;object-fit:cover">
                                        <img src="{{ asset($data->photo) }}">
                                    </div>
                                @else
                                    <div class="fileinput-preview img-thumbnail text-center" data-trigger="fileinput" style="width: 135px; height: 150px;object-fit:cover">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                @endif
                            </td>
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