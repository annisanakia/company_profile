@extends('layouts.layout')

@section('content')
<style>
    .groups{
        cursor: pointer;
        font-weight: bold;
        color: #3c8dbc;
    }

    .disabled{		
        color:rgb(136, 136, 136);
        font-weight: normal;
    }
</style>
{{ Form::model($data, ['method' => 'PATCH','route'=>[$controller_name.'.update',$data->id], 'id'=>'form-tab-ajax', 'class'=>'form-validation', 'linkIndex'=>url($controller_name)]) }}

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
                <div class="form-group <?php if ($errors->has('name')) echo 'has-error' ?>">
                    {{ Form::label('Name', 'Name', array('class'=>'control-label')) }}
                    {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Name')) }}
                    {!!$errors->first('name', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('parent')) echo 'has-error' ?>">
                    {{ Form::label('Parent', 'Parent', array('class'=>'control-label')) }}
                    {{ Form::select('parent', ([''=>'-- Select Parent --', 0=>'No Parent']+Models\job::nestedSelect()), null, array('class'=>'form-control selectpicker', 'data-live-search'=>'true')) }}
                    {!!$errors->first('parent', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('ordering')) echo 'has-error' ?>">
                    {{ Form::label('Ordering', 'Ordering', array('class'=>'control-label')) }}
                    {{ Form::number('ordering', null, array('class'=>'form-control', 'placeholder'=>'Ordering')) }}
                    {!!$errors->first('ordering', ' <span class="form-text error">:message</span>')!!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group <?php if ($errors->has('display')) echo 'has-error' ?>">
                    {{ Form::label('Display', 'Display', array('class'=>'control-label')) }}
                    {{ Form::select('display', [''=>'-- Select Publish --', 1=>'Publish', 2=>'Draft'], null, array('class'=>'form-control selectpicker')) }}
                    {!!$errors->first('display', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('menu_type_id')) echo 'has-error' ?>">
                    {{ Form::label('Menu Type', 'Menu Type', array('class'=>'control-label')) }}
                    {{ Form::select('menu_type_id', [''=>'-- Select Tipe Menu --']+Models\menu_type::pluck('name','id')->all(), null, array('class'=>'form-control selectpicker')) }}
                    {!!$errors->first('menu_type_id', ' <span class="form-text error">:message</span>')!!}
                </div>
                <div class="form-group <?php if ($errors->has('icon')) echo 'has-error' ?>">
                    {{ Form::label('Icon', 'Icon', array('class'=>'control-label')) }}
                    {{ Form::text('icon', null, array('class'=>'form-control', 'placeholder'=>'Icon ex : fa fa-folder fa-lg')) }}
                    <span class="form-text text-muted">Dictonary Icon : <a href="http://fontawesome.io/icons/" target="_blank">Fontawesome</a>.</span>
                    {!!$errors->first('icon', ' <span class="form-text error">:message</span>')!!}
                </div>
            </div>
            <div class="col-md-12">
                <table id="privilege" class="table table-bordered" >
                    <thead>
                        <tr>
                            <th>User Group</th>
                            <th>Tambah</th>
                            <th>Ubah</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
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
                                        <input type="hidden" name="add_priv[{{$ug['groups_id']}}]" value="0">
                                        <label class="switch-btn hak">
                                            <input class="hak" type="checkbox" name="add_priv[{{$ug['groups_id']}}]" value="1" {{$ug['add_priv'] ? 'checked' : ''}}  {{$ug['status']}}>
                                            <div class="slider"></div>
                                        </label>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" name="edit_priv[{{$ug['groups_id']}}]" value="0">
                                        <label class="switch-btn hak">
                                            <input class="hak" type="checkbox" name="edit_priv[{{$ug['groups_id']}}]" value="1" {{$ug['edit_priv'] ? 'checked' : ''}}  {{$ug['status']}}>
                                            <div class="slider"></div>
                                        </label>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" name="remove_priv[{{$ug['groups_id']}}]" value="0">
                                        <label class="switch-btn">
                                            <input class="hak" type="checkbox" name="remove_priv[{{$ug['groups_id']}}]" value="1" {{$ug['remove_priv'] ? 'checked' : ''}}  {{$ug['status']}}>
                                            <div class="slider"></div>
                                        </label>
                                    </label>
                                </div>
                            </td>
                        </tr>	
                        @endforeach  			
                    </tbody>
                </table>
                @include('component.actions')
            </div>
        </div>
    </div>
</div>
</div>
{{ Form::close() }}

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
@endsection