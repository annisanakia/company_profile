@extends('layouts.layout')

@section('content')

{{ Form::model($data, ['method' => 'PATCH','route'=>[$controller_name.'.update',$data->id], 'class'=>'form-validation', 'enctype'=>'multipart/form-data']) }}

<div class="title-table">
    {{$title}}
</div>

<div class="card">
<div class="card-body">
    <div class="title-form">
        Edit Account
    </div>
    <div class="block-form">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group  <?php if ($errors->has('name')) echo 'has-error' ?>">
                    {{ Form::label('Name', 'Name', array('class'=>'control-label')) }}
                    {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Name')) }}
                    {!!$errors->first('name', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group  <?php if ($errors->has('username')) echo 'has-error' ?>">
                    {{ Form::label('Username', 'Username', array('class'=>'control-label')) }}
                    {{ Form::text('username', null, array('class'=>'form-control', 'placeholder'=>'Username')) }}
                    {!!$errors->first('username', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('password')) echo 'has-error' ?>">
                    {{ Form::label('Password', 'Password', array('class'=>'control-label')) }}
                    {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
                    {!!$errors->first('password', ' <span class="form-text error">:message</span>')!!}
                    <span class="help-block">Abaikan jika tidak ingin mengganti password</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group <?php if ($errors->has('email')) echo 'has-error' ?>">
                    {{ Form::label('Email', 'Email', array('class'=>'control-label')) }}
                    {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email')) }}
                    {!!$errors->first('email', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('phone')) echo 'has-error' ?>">
                    {{ Form::label('Phone', 'Phone', array('class'=>'control-label')) }}
                    {{ Form::text('phone', null, array('class'=>'form-control', 'placeholder'=>'Phone')) }}
                    {!!$errors->first('phone', ' <span class="form-text error">:message</span>')!!}
                </div>
            </div>
        </div>
        <div class="form-group <?php if ($errors->has('filename')) echo 'has-error' ?>">
            {{ Form::label('Photo Profile', 'Photo Profile', array('class'=>'control-label')) }}<br>
            <div class="fileinput fileinput-new" data-provides="fileinput">
                @if(isset($data->users_photo->filename))
                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 135px; height: 150px;object-fit:cover">
                        <img src="{{ asset($data->users_photo->filename) }}">
                    </div>
                @else
                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 135px; height: 150px;object-fit:cover">
                        <i class="fas fa-camera"></i>
                    </div>
                @endif
                <div>
                    <span class="btn btn-outline-secondary btn-file">
                        <span class="fileinput-new">Select Photo</span>
                        <span class="fileinput-exists">Change Photo</span>
                        <input type="file" name="filename" value="{{ isset($data->users_photo->filename)? $data->users_photo->filename : '' }}">
                    </span>
                </div>
            </div>
            <span class="form-text text-muted">Upload file berformat JPEG, PNG, JPG.<br>Maksimal ukuran file 2 Mb.</span>
            {!!$errors->first('filename', ' <span class="form-text error">:message</span>')!!}
        </div>
        @include('component.actions')
    </div>
</div>
</div>

{{ Form::close() }}

<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-fileinput/css/jasny-bootstrap.min.css')}}"/>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-fileinput/js/jasny-bootstrap.min.js')}}"></script>
@endsection