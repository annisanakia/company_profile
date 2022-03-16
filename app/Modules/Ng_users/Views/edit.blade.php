{{ Form::model($data, ['method' => 'PATCH','route'=>[$controller_name.'.update',$data->id], 'id'=>'form-tab-ajax', 'class'=>'form-validation', 'linkIndex'=>url($controller_name)]) }}

<div class="block-form">
    <div class="form-group <?php if ($errors->has('ng_department_id')) echo 'has-error' ?>">
        {{ Form::select('ng_department_id', ([''=>'-- Select Department --']+Models\ng_department::nestedSelect()), null, array('class'=>'form-control selectpicker', 'data-live-search'=>'true')) }}
        {!!$errors->first('ng_department_id', ' <span class="form-text error">:message</span>')!!}
    </div>
    <div class="form-group <?php if ($errors->has('username')) echo 'has-error' ?>">
        {{ Form::text('username', null, array('class'=>'form-control', 'placeholder'=>'Username', 'disabled'=>'disabled')) }}
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
            @if(isset($data->users_photo->filename))
                <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 135px; height: 150px;object-fit:cover">
                    <img src="{{ $data->users_photo->filename }}">
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
</div>
<table id="privilege" class="table table-bordered" >
    <thead>
        <tr>
            <th>User Group</th>
            <th>Default</th>
        </tr>
    </thead>
    <tbody>
        @if(count($user_group) > 0)
        @foreach ($user_group as $ug)
        <tr>
            <td class="groups {{$ug['status']}}">          
                {{$ug['name']}}
                <input type="hidden" name="groups_id[]" value="{{$ug['groups_id']}}">
                <input type="hidden" class="status" name="status[]" value="{{$ug['status']}}">
            </td>
            <td>
                <div class="checkbox">
                    <label>
                        <label class="switch-btn hak">
                            <input class="hak" type="radio" name="default" value="{{$ug['groups_id']}}" {{$ug['default'] ? 'checked' : ''}}  {{$ug['status']}}>
                            <div class="slider"></div>
                        </label>
                    </label>
                </div>
            </td>
        </tr>	
        @endforeach
        @endif                    
    </tbody>
</table>

{{ Form::close() }}

<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $(".selectpicker").selectpicker();
        $('#privilege').on('click', '.groups', function (e) {
            if ($(this).hasClass('disabled')) {
                $(this).removeClass('disabled');
                $(this).parent('tr').find('.hak').removeAttr('disabled');
                $(this).parent('tr').find('.status').val('');
            } else {
                $(this).addClass('disabled');
                $(this).parent('tr').find('.hak').attr('disabled', true);
                $(this).parent('tr').find('.status').val('disabled');
            }
        });
    });
</script>