{{ Form::open(array('route' => $controller_name.'.store', 'id'=>'form-tab-ajax', 'class'=>'form-validation', 'linkIndex'=>url($controller_name))) }}

<div class="block-form">
    <div class="form-group <?php if ($errors->has('ng_department_id')) echo 'has-error' ?>">
        {{ Form::select('ng_department_id', ([''=>'-- Select Department --']+Models\ng_department::nestedSelect()), null, array('class'=>'form-control selectpicker', 'data-live-search'=>'true')) }}
        {!!$errors->first('ng_department_id', ' <span class="form-text error">:message</span>')!!}
    </div>
    <div class="form-group <?php if ($errors->has('username')) echo 'has-error' ?>">
        {{ Form::text('username', null, array('class'=>'form-control', 'placeholder'=>'Username')) }}
        {!!$errors->first('username', ' <span class="form-text error">:message</span>')!!}
    </div>
    <div class="form-group <?php if ($errors->has('password')) echo 'has-error' ?>">
        {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
        {!!$errors->first('password', ' <span class="form-text error">:message</span>')!!}
    </div>
    <div class="form-group <?php if ($errors->has('name')) echo 'has-error' ?>">
        {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Name')) }}
        {!!$errors->first('name', ' <span class="form-text error">:message</span>')!!}
    </div>
    <div class="form-group <?php if ($errors->has('email')) echo 'has-error' ?>">
        {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email')) }}
        {!!$errors->first('email', ' <span class="form-text error">:message</span>')!!}
    </div>
    <div class="form-group <?php if ($errors->has('phone')) echo 'has-error' ?>">
        {{ Form::text('phone', null, array('class'=>'form-control', 'placeholder'=>'Phone')) }}
        {!!$errors->first('phone', ' <span class="form-text error">:message</span>')!!}
    </div>
    <div class="form-group <?php if ($errors->has('filename')) echo 'has-error' ?>">
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 135px; height: 150px;object-fit:cover">
                <i class="fas fa-camera"></i>
            </div>
            <div>
                <span class="btn btn-outline-secondary btn-file">
                    <span class="fileinput-new">Select Photo</span>
                    <span class="fileinput-exists">Change Photo</span>
                    <input type="file" name="filename">
                </span>
            </div>
        </div>
        <span class="form-text text-muted">Upload file berformat JPEG, PNG, JPG.<br>Maksimal ukuran file 2 Mb.</span>
        {!!$errors->first('filename', ' <span class="form-text error">:message</span>')!!}
    </div>
</div>

{{ Form::close() }}

<script type="text/javascript">
    $(document).ready(function() {
        $(".selectpicker").selectpicker();
    });
</script>