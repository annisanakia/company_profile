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
        <div class="form-group row">
            <div class="col-md-6 <?php if ($errors->has('code')) echo 'has-error' ?>">
                {{ Form::text('code', null, array('class'=>'form-control', 'placeholder'=>'Code')) }}
                {!!$errors->first('code', ' <span class="form-text error">:message</span>')!!}
            </div>
            <div class="col-md-6 <?php if ($errors->has('name')) echo 'has-error' ?>">
                {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Name')) }}
                {!!$errors->first('name', ' <span class="form-text error">:message</span>')!!}
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
            if(component_type != 8){
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