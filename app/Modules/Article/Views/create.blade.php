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
                <div class="form-group <?php if ($errors->has('article_category_id')) echo 'has-error' ?>">
                    {{ Form::label('Article Category', 'Article Category', array('class'=>'control-label')) }}
                    {{ Form::select('article_category_id', [''=>'-- Choose Category --']+\Models\article_category::pluck('name','id')->all(), null, array('class'=>'form-control selectpicker')) }}
                    {!!$errors->first('article_category_id', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('title')) echo 'has-error' ?>">
                    {{ Form::label('Title', 'Title', array('class'=>'control-label')) }}
                    {{ Form::text('title', null, array('class'=>'form-control', 'placeholder'=>'Title')) }}
                    {!!$errors->first('title', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('date')) echo 'has-error' ?>">
                    {{ Form::label('Article Date', 'Article Date', array('class'=>'control-label')) }}
                    {{ Form::date('date', isset($data)? $data->date : date('Y-m-d'), array('class'=>'form-control')) }}
                    {!!$errors->first('date', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('sequence')) echo 'has-error' ?>">
                    {{ Form::label('Ordering', 'Ordering', array('class'=>'control-label')) }}
                    {{ Form::text('sequence', isset($data)? $data->sequence : '', array('class'=>'form-control', 'placeholder'=>'Ordering')) }}
                    {!!$errors->first('sequence', ' <span class="form-text error">:message</span>')!!}
                    <span class="help-block">Urutan untuk ditampilkan di dashboard website</span>
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
                Photo Article
            </div>
            <div class="block-form">
                <div class="form-group <?php if ($errors->has('photo')) echo 'has-error' ?>">
                    {{ Form::label('Photo Article', 'Photo Article', array('class'=>'control-label')) }}<br>
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
                Article Detail
            </div>
            <div class="block-form">
                <div class="form-group <?php if ($errors->has('desc')) echo 'has-error' ?>">
                    {{ Form::label('Description', 'Description', array('class'=>'control-label')) }}
                    {{ Form::textarea('desc', isset($data)? $data->desc : '', array('class'=>'form-control summernote', 'rows'=>'3', 'placeholder'=>'Description')) }}
                    {!!$errors->first('desc', ' <span class="form-text error">:message</span>')!!}
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.summernote').summernote({
            dialogsInBody: true,
            placeholder: 'Deskripsi',
            tabsize: 2,
            height: 130
        });
    });
</script>
@endsection