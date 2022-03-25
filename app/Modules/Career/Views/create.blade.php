@extends('layouts.layout')

@section('content')

{{ Form::open(array('route' => $controller_name.'.store', 'class'=>'form-validation', 'enctype'=>'multipart/form-data')) }}
{{ Form::hidden('users_id', Auth::user()->id) }}

<div class="title-table">
    {{$title}}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
        <div class="card-body">
            <div class="title-form">
                {{$title_form}}
            </div>
            <div class="block-form">
                <div class="form-group <?php if ($errors->has('career_type_id')) echo 'has-error' ?>">
                    {{ Form::label('Career Type', 'Career Type', array('class'=>'control-label')) }}
                    {{ Form::select('career_type_id', [''=>'-- Choose Type --']+\Models\career_type::pluck('name','id')->all(), null, array('class'=>'form-control selectpicker')) }}
                    {!!$errors->first('career_type_id', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('name')) echo 'has-error' ?>">
                    {{ Form::label('Name', 'Name', array('class'=>'control-label')) }}
                    {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Name')) }}
                    {!!$errors->first('name', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group row">
                    <div class="col-md-6 <?php if ($errors->has('start_date')) echo 'has-error' ?>">
                        {{ Form::label('Date Job Vacancy', 'Date Job Vacancy (Start)', array('class'=>'control-label')) }}
                        {{ Form::date('start_date', isset($data)? $data->start_date : date('Y-m-d'), array('class'=>'form-control')) }}
                        {!!$errors->first('start_date', ' <span class="form-text error">:message</span>')!!}
                    </div>
                    <div class="col-md-6 <?php if ($errors->has('end_date')) echo 'has-error' ?>">
                        {{ Form::label('Date Job Vacancy', 'Date Job Vacancy (End)', array('class'=>'control-label')) }}
                        {{ Form::date('end_date', isset($data)? $data->end_date : date('Y-m-d'), array('class'=>'form-control')) }}
                        {!!$errors->first('end_date', ' <span class="form-text error">:message</span>')!!}
                    </div>
                </div>
                <div class="form-group <?php if ($errors->has('is_publish')) echo 'has-error' ?>">
                    {{ Form::label('Status Publish', 'Status Publish', array('class'=>'control-label')) }}
                    {{ Form::select('is_publish', [1=>'Publish', 2=>'Draft'], isset($data)? $data->is_publish : 1, array('class'=>'form-control selectpicker')) }}
                    {!!$errors->first('is_publish', ' <span class="form-text error">:message</span>')!!}
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
        <div class="card-body">
            <div class="title-form">
                Upload Image
            </div>
            <div class="block-form">
                <div class="form-group <?php if ($errors->has('photo')) echo 'has-error' ?>">
                    {{ Form::label('Upload Image', 'Upload Image', array('class'=>'control-label')) }}<br>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        @if(isset($data) && $data->photo != '')
                            <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 150px; height: 150px;object-fit:cover">
                                <img src="{{ asset($data->photo) }}">
                            </div>
                        @else
                            <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 150px; height: 150px;object-fit:cover">
                                <i class="fas fa-camera"></i>
                            </div>
                        @endif
                        <div>
                            <span class="btn btn-outline-secondary btn-file">
                                <span class="fileinput-new">Select Photo</span>
                                <span class="fileinput-exists">Change Photo</span>
                                <input type="file" name="photo" value="{{ isset($data->photo)? $data->photo : '' }}">
                            </span>
                        </div>
                    </div>
                    <span class="form-text text-muted">Upload file berformat JPEG, PNG, JPG.<br>Maksimal ukuran file 2 Mb.</span>
                    {!!$errors->first('photo', ' <span class="form-text error">:message</span>')!!}
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
        <div class="card-body">
            <div class="title-form">
                Career Detail
            </div>
            <div class="block-form">
                <div class="form-group row">
                <div class="col-md-6 <?php if ($errors->has('desc')) echo 'has-error' ?>">
                    {{ Form::label('Description', 'Description', array('class'=>'control-label')) }}
                    {{ Form::textarea('desc', isset($data)? $data->desc : '', array('class'=>'form-control', 'rows'=>'3', 'placeholder'=>'Description')) }}
                    {!!$errors->first('desc', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="col-md-6 <?php if ($errors->has('qualification')) echo 'has-error' ?>">
                    {{ Form::label('Qualification', 'Qualification', array('class'=>'control-label')) }}
                    {{ Form::textarea('qualification', isset($data)? $data->qualification : '', array('class'=>'form-control', 'rows'=>'3', 'placeholder'=>'Qualification')) }}
                    {!!$errors->first('qualification', ' <span class="form-text error">:message</span>')!!}
                </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-12">
        @include('component.actions')
    </div>
</div>
<br>

{{ Form::close() }}

<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-fileinput/css/jasny-bootstrap.min.css')}}"/>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-fileinput/js/jasny-bootstrap.min.js')}}"></script>
@endsection