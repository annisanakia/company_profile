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
                <div class="form-group <?php if ($errors->has('name')) echo 'has-error' ?>">
                    {{ Form::label('Name', 'Name', array('class'=>'control-label')) }}
                    {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Name')) }}
                    {!!$errors->first('name', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('slug')) echo 'has-error' ?>">
                    {{ Form::label('Link', 'Link', array('class'=>'control-label')) }}
                    {{ Form::text('slug', null, array('class'=>'form-control', 'placeholder'=>'Link')) }}
                    {!!$errors->first('slug', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('parent')) echo 'has-error' ?>">
                    {{ Form::label('Parent', 'Parent', array('class'=>'control-label')) }}
                    {{ Form::select('parent', ([''=>'-- Select Parent --', 0=>'No Parent']+Models\ng_menu::nestedSelect()), null, array('class'=>'form-control selectpicker', 'data-live-search'=>'true')) }}
                    {!!$errors->first('parent', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('ordering')) echo 'has-error' ?>">
                    {{ Form::label('Ordering', 'Ordering', array('class'=>'control-label')) }}
                    {{ Form::number('ordering', null, array('class'=>'form-control', 'placeholder'=>'Ordering')) }}
                    {!!$errors->first('ordering', ' <span class="form-text error">:message</span>')!!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group <?php if ($errors->has('component_type')) echo 'has-error' ?>">
                    {{ Form::label('Component Type', 'Component Type', array('class'=>'control-label')) }}
                    {{ Form::select('component_type', [''=>'-- Select Component Type --']+getComponentType(), null, array('class'=>'form-control selectpicker', 'id'=>'component_type')) }}
                    {!!$errors->first('component_type', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('component_link')) echo 'has-error' ?>">
                    {{ Form::label('Component Link', 'Component Link', array('class'=>'control-label')) }}
                    {{ Form::select('component_link', [''=>'-- Select Component --'], null, array('class'=>'form-control selectpicker', 'id'=>'component_link')) }}
                    {{ Form::text('component_link',  null, array('class'=>'form-control', 'id'=>'component_link_text', 'placeholder'=>'Component Link')) }}
                    {!!$errors->first('component_link', ' <span class="form-text error">:message</span>')!!}
                    <span class="help-block">Diisi jika ingin menu ke postingan khusus</span>
                </div>
                <div class="form-group <?php if ($errors->has('display')) echo 'has-error' ?>">
                    {{ Form::label('Publish', 'Publish', array('class'=>'control-label')) }}
                    {{ Form::select('display', [''=>'-- Select Publish --', 1=>'Publish', 2=>'Draft'], 1, array('class'=>'form-control selectpicker')) }}
                    {!!$errors->first('display', ' <span class="form-text error">:message</span>')!!}
                </div>
            </div>
        </div>
        @include('component.actions')
    </div>
</div>
</div>

{{ Form::close() }}

<script type="text/javascript" src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".selectpicker").selectpicker();

        function filterComponent(component_type, selected){
            if(component_type != 6){
                $('#component_link').prop('disabled', false);
                $('#component_link').removeClass('sr-only');
                $('.bootstrap-select').removeClass('sr-only');
                $('#component_link_text').prop('disabled', true);
                $('#component_link_text').addClass('sr-only');
                var url = '{{url($controller_name."/filterComponent")}}';
                var data = {component_type : component_type, id: selected};
                $.ajax({
                    url: url,
                    data: data,
                    success: function (e) {
                        $('#component_link').html(e);
                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            }else{
                $('#component_link_text').prop('disabled', false);
                $('#component_link_text').removeClass('sr-only');
                $('#component_link').prop('disabled', true);
                $('#component_link').addClass('sr-only');
                $('.selectpicker').selectpicker('refresh');
            }
        }

        filterComponent(<?php echo isset($data->component_type) ? ($data->component_type != '' ? $data->component_type : 0) : 0 ?>, '<?php echo isset($data->component_link) ? ($data->component_link != '' ? $data->component_link : 0) : 0 ?>');
        $('#component_type').change(function () {
            filterComponent($('#component_type').val());
        });
    });
</script>
@endsection