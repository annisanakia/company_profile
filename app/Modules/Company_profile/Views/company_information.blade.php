<style>
    .img-thumbnail i {
        padding-top: 38px;
    }
</style>
{{ Form::open(array('route' => $controller_name.'.detailInformationSave', 'id'=>'form-tab-ajax', 'class'=>'form-validation', 'enctype'=>'multipart/form-data')) }}

@if(Session::has('msg'))
<div class="alert alert-success text-center" id="hideMe">
    {!! Session::get('msg') !!}
</div>
@endif
@include('component.actions')
<div class="row">
    <div class="col-md-6">
        <div class="card">
        <div class="card-body">
            <div class="title-form">
                Detail Company
            </div>
            <div class="block-form">
                <div class="form-group <?php if ($errors->has('code')) echo 'has-error' ?>">
                    {{ Form::label('Code', 'Code', array('class'=>'control-label')) }}
                    {{ Form::text('code', $data->code, array('class'=>'form-control', 'placeholder'=>'Code')) }}
                    {!!$errors->first('code', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('name')) echo 'has-error' ?>">
                    {{ Form::label('Name', 'Name', array('class'=>'control-label')) }}
                    {{ Form::text('name', $data->name, array('class'=>'form-control', 'placeholder'=>'Name')) }}
                    {!!$errors->first('name', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('phone_no')) echo 'has-error' ?>">
                    {{ Form::label('Phone No', 'Phone No', array('class'=>'control-label')) }}
                    {{ Form::text('phone_no', $data->phone_no, array('class'=>'form-control', 'placeholder'=>'Phone No')) }}
                    {!!$errors->first('phone_no', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('email')) echo 'has-error' ?>">
                    {{ Form::label('Email', 'Email', array('class'=>'control-label')) }}
                    {{ Form::text('email', $data->email, array('class'=>'form-control', 'placeholder'=>'Email')) }}
                    {!!$errors->first('email', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('address')) echo 'has-error' ?>">
                    {{ Form::label('Address', 'Address', array('class'=>'control-label')) }}
                    {{ Form::textarea('address', $data->address, array('class'=>'form-control', 'rows'=>'3', 'placeholder'=>'Address')) }}
                    {!!$errors->first('address', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('desc')) echo 'has-error' ?>">
                    {{ Form::label('Description', 'Description', array('class'=>'control-label')) }}
                    {{ Form::textarea('desc', $data->desc, array('class'=>'form-control', 'rows'=>'3', 'placeholder'=>'Description')) }}
                    {!!$errors->first('desc', ' <span class="form-text error">:message</span>')!!}
                </div>
            </div>
        </div>
        </div>
        <div class="card">
        <div class="card-body">
            <div class="title-form">
                Sosial Media
            </div>
            <div class="block-form">
                <div class="form-group <?php if ($errors->has('instagram')) echo 'has-error' ?>">
                    {{ Form::label('Instagram', 'Instagram', array('class'=>'control-label')) }}
                    {{ Form::text('instagram', $data->instagram, array('class'=>'form-control', 'placeholder'=>'Instagram')) }}
                    {!!$errors->first('instagram', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('facebook')) echo 'has-error' ?>">
                    {{ Form::label('Facebook', 'Facebook', array('class'=>'control-label')) }}
                    {{ Form::text('facebook', $data->facebook, array('class'=>'form-control', 'placeholder'=>'Facebook')) }}
                    {!!$errors->first('facebook', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('twitter')) echo 'has-error' ?>">
                    {{ Form::label('Twitter', 'Twitter', array('class'=>'control-label')) }}
                    {{ Form::text('twitter', $data->twitter, array('class'=>'form-control', 'placeholder'=>'Facebook')) }}
                    {!!$errors->first('twitter', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('whatsapp')) echo 'has-error' ?>">
                    {{ Form::label('Whatsapp', 'Whatsapp', array('class'=>'control-label')) }}
                    {{ Form::text('whatsapp', $data->whatsapp, array('class'=>'form-control', 'placeholder'=>'Whatsapp')) }}
                    {!!$errors->first('whatsapp', ' <span class="form-text error">:message</span>')!!}
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
        <div class="card-body">
            <div class="title-form">
                Logo Company
            </div>
            <div class="block-form">
                <div class="form-group <?php if ($errors->has('logo')) echo 'has-error' ?>">
                    {{ Form::label('Logo Company', 'Logo Company', array('class'=>'control-label')) }}<br>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        @if($data->logo != '')
                            <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 180px; height: 135px;object-fit:cover">
                                <img src="{{ asset($data->logo) }}">
                            </div>
                        @else
                            <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 180px; height: 135px;object-fit:cover">
                                <i class="fas fa-camera"></i>
                            </div>
                        @endif
                        <div>
                            <span class="btn btn-outline-secondary btn-file">
                                <span class="fileinput-new">Select Photo</span>
                                <span class="fileinput-exists">Change Photo</span>
                                <input type="file" name="logo" value="{{ isset($data->logo)? $data->logo : '' }}">
                            </span>
                        </div>
                    </div>
                    <span class="form-text text-muted">Upload file berformat JPEG, PNG, JPG.<br>Maksimal ukuran file 2 Mb.</span>
                    {!!$errors->first('filename', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('logo_white')) echo 'has-error' ?>">
                    {{ Form::label('Logo White Company', 'Logo White Company', array('class'=>'control-label')) }}<br>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        @if($data->logo_white != '')
                            <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 180px; height: 135px;object-fit:cover">
                                <img src="{{ asset($data->logo_white) }}">
                            </div>
                        @else
                            <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 180px; height: 135px;object-fit:cover">
                                <i class="fas fa-camera"></i>
                            </div>
                        @endif
                        <div>
                            <span class="btn btn-outline-secondary btn-file">
                                <span class="fileinput-new">Select Photo</span>
                                <span class="fileinput-exists">Change Photo</span>
                                <input type="file" name="logo_white" value="{{ isset($data->logo_white)? $data->logo_white : '' }}">
                            </span>
                        </div>
                    </div>
                    <span class="form-text text-muted">Upload file berformat JPEG, PNG, JPG.<br>Maksimal ukuran file 2 Mb.</span>
                    {!!$errors->first('logo_white', ' <span class="form-text error">:message</span>')!!}
                </div>
            </div>
        </div>
        </div>
        <div class="card">
        <div class="card-body">
            <div class="title-form">
                Sosial Media
            </div>
            <div class="block-form">
                <div class="form-group <?php if ($errors->has('visi')) echo 'has-error' ?>">
                    {{ Form::label('Visi', 'Visi', array('class'=>'control-label')) }}
                    {{ Form::textarea('visi', $data->visi, array('class'=>'form-control', 'rows'=>'3', 'placeholder'=>'Visi')) }}
                    {!!$errors->first('visi', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('misi')) echo 'has-error' ?>">
                    {{ Form::label('Misi', 'Misi', array('class'=>'control-label')) }}
                    {{ Form::textarea('misi', $data->misi, array('class'=>'form-control', 'rows'=>'3', 'placeholder'=>'Misi')) }}
                    {!!$errors->first('misi', ' <span class="form-text error">:message</span>')!!}
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
    $(".form-validation").validate();
    $('.tab-ajax-navigation .submit').click(function (e) {
        // Abort any currently executing request
        if(request) {
            request.abort();
        }
        if ($(".form-validation").valid()) {
            var url = $('#form-tab-ajax').attr('action');
            var data = $('#form-tab-ajax').serialize();

            $('#container').append('<div class="loader"><img src="/assets/images/preloader.svg"/></div>');

            $(".form-validation").ajaxForm({
                success: function (e) {
                    $('#container').html(e);
                }
            }).submit();
        }

        return false;
    });
});
</script>