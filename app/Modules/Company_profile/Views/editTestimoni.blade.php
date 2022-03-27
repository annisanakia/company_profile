<style>
    .img-thumbnail i {
        padding-top: 38px;
    }
</style>
{{ Form::open(array('route' => $controller_name.'.saveTestimoni', 'id'=>'form-tab-ajax', 'class'=>'form-validation', 'enctype'=>'multipart/form-data')) }}
{{ Form::hidden('id', isset($data)? $data->id : '') }}

@include('component.actions')
<div class="row">
    <div class="col-md-6">
        <div class="card">
        <div class="card-body">
            <div class="title-form">
                {{ $data? 'Edit Data' : 'Add Data' }}
            </div>
            <div class="block-form">
                <div class="form-group <?php if ($errors->has('name')) echo 'has-error' ?>">
                    {{ Form::label('Name', 'Name', array('class'=>'control-label')) }}
                    {{ Form::text('name', isset($data)? $data->name : '', array('class'=>'form-control', 'placeholder'=>'Name')) }}
                    {!!$errors->first('name', ' <span class="form-text error">:message</span>')!!}
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
                Image Testimoni
            </div>
            <div class="block-form">
                <div class="form-group <?php if ($errors->has('photo')) echo 'has-error' ?>">
                    {{ Form::label('Photo Profile', 'Photo Profile', array('class'=>'control-label')) }}<br>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        @if(isset($data) && $data->photo != '')
                            <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 135px; height: 150px;object-fit:cover">
                                <img src="{{ asset($data->photo) }}">
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
                Testimoni Detail
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
</div>
{{ Form::close() }}

<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-fileinput/css/jasny-bootstrap.min.css')}}"/>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-fileinput/js/jasny-bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/plugins/jquery-validation/jquery.form.js')}}" type="text/javascript"></script>

<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.css')}}">
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<script type="text/javascript">
    var request;
    $(document).ready(function () {
    $(".selectpicker").selectpicker();
    $(".form-validation").validate();
    $('.summernote').summernote({
        dialogsInBody: true,
        placeholder: 'Deskripsi',
        tabsize: 2,
        height: 130
    });
    $('.tab-ajax-navigation .submit').click(function (e) {
        // Abort any currently executing request
        if(request) {
            request.abort();
        }
        if ($(".form-validation").valid()) {
            var url = $('#form-tab-ajax').attr('action');
            var data = $('#form-tab-ajax').serialize();
            var target = '#container';

            $(target).append('<div class="loader"><img src="/assets/images/preloader.svg"/></div>');

            $(".form-validation").ajaxForm({
                success: function (e) {
                    var scope = angular.element(target).scope();
                    scope.compiled(e, target);
                    scope.$apply();
                }
            }).submit();
        }

        return false;
    });
    $('.btn-cancel').click(function (e) {
        e.preventDefault();
        var $this = $(this),
                url = $this.attr('href')
                target = '#container';
        
        $(target).append('<div class="loader"><img src="/assets/images/preloader.svg"/></div>');

        $.ajax({
            url: url,
            success: function (e) {
                var scope = angular.element(target).scope();
                scope.compiled(e, target);
                scope.$apply();
            }
        });

        return false;
    });
});
</script>