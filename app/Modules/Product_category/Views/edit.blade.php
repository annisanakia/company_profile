@extends('layouts.layout')

@section('content')

{{ Form::model($data, ['method' => 'PATCH','route'=>[$controller_name.'.update',$data->id], 'class'=>'form-validation']) }}

<div class="title-table">
    {{$title}}
</div>

<div class="card">
<div class="card-body">
    <div class="title-form">
        {{$title_form}}
    </div>
    <div class="block-form">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group <?php if ($errors->has('code')) echo 'has-error' ?>">
                    {{ Form::label('Code', 'Code', array('class'=>'control-label')) }}
                    {{ Form::text('code', null, array('class'=>'form-control', 'placeholder'=>'Code')) }}
                    {!!$errors->first('code', ' <span class="form-text error">:message</span>')!!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group <?php if ($errors->has('name')) echo 'has-error' ?>">
                    {{ Form::label('Name', 'Name', array('class'=>'control-label')) }}
                    {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Name')) }}
                    {!!$errors->first('name', ' <span class="form-text error">:message</span>')!!}
                </div>
            </div>
        </div>
        @include('component.actions')
    </div>
</div>
</div>

{{ Form::close() }}

@endsection