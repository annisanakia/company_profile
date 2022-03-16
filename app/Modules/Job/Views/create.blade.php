{{ Form::open(array('route' => $controller_name.'.store', 'id'=>'form-tab-ajax', 'class'=>'form-validation', 'linkIndex'=>url($controller_name))) }}

<div class="block-form">
    <div class="form-group <?php if ($errors->has('code')) echo 'has-error' ?>">
        {{ Form::text('code', null, array('class'=>'form-control', 'placeholder'=>'Code')) }}
        {!!$errors->first('code', ' <span class="form-text error">:message</span>')!!}
    </div>
    <div class="form-group <?php if ($errors->has('name')) echo 'has-error' ?>">
        {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Name')) }}
        {!!$errors->first('name', ' <span class="form-text error">:message</span>')!!}
    </div>
    <div class="form-group <?php if ($errors->has('parent')) echo 'has-error' ?>">
        {{ Form::select('parent', ([''=>'-- Select Parent --', 0=>'No Parent']+Models\job::nestedSelect()), null, array('class'=>'form-control selectpicker', 'data-live-search'=>'true')) }}
        {!!$errors->first('parent', ' <span class="form-text error">:message</span>')!!}
    </div>
    <div class="form-group <?php if ($errors->has('ordering')) echo 'has-error' ?>">
        {{ Form::number('ordering', null, array('class'=>'form-control', 'placeholder'=>'Urutan')) }}
        {!!$errors->first('ordering', ' <span class="form-text error">:message</span>')!!}
    </div>
    <div class="form-group <?php if ($errors->has('display')) echo 'has-error' ?>">
        {{ Form::select('display', [''=>'-- Select Publish --', 1=>'Publish', 2=>'Draft'], null, array('class'=>'form-control selectpicker')) }}
        {!!$errors->first('display', ' <span class="form-text error">:message</span>')!!}
    </div>
    <div class="form-group <?php if ($errors->has('menu_type_id')) echo 'has-error' ?>">
        {{ Form::select('menu_type_id', [''=>'-- Select Tipe Menu --']+Models\menu_type::pluck('name','id')->all(), null, array('class'=>'form-control selectpicker')) }}
        {!!$errors->first('menu_type_id', ' <span class="form-text error">:message</span>')!!}
    </div>
    <div class="form-group <?php if ($errors->has('icon')) echo 'has-error' ?>">
        {{ Form::text('icon', null, array('class'=>'form-control', 'placeholder'=>'Icon ex : fa fa-folder fa-lg')) }}
        <span class="form-text text-muted">Dictonary Icon : <a href="http://fontawesome.io/icons/" target="_blank">Fontawesome</a>.</span>
        {!!$errors->first('icon', ' <span class="form-text error">:message</span>')!!}
    </div>
</div>

{{ Form::close() }}

<script type="text/javascript" src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".selectpicker").selectpicker();
    });
</script>