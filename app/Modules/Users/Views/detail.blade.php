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

<div class="card">
<div class="card-body">
    <div class="title-form">
        {{$title_form}}
    </div>
    <div class="block-form">
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                        <tr>
                            <td width="150px">Username</td>
                            <td>:</td>
                            <td>{{ isset($data->username)? $data->username : '' }}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td>{{ isset($data->name)? $data->name : '' }}</td>
                        </tr>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                        <tr>
                            <td width="150px">Email</td>
                            <td>:</td>
                            <td>{{ isset($data->email)? $data->email : '' }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>:</td>
                            <td>{{ isset($data->phone)? $data->phone : '' }}</td>
                        </tr>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                        <tr>
                            <td width="150px">Photo Profile</td>
                            <td>:</td>
                            <td>
                                @if(isset($data->users_photo->filename))
                                    <div class="fileinput-preview img-thumbnail text-center" data-trigger="fileinput" style="width: 135px; height: 150px;object-fit:cover">
                                        <img src="{{ asset($data->users_photo->filename) }}">
                                    </div>
                                @else
                                    <div class="fileinput-preview img-thumbnail text-center" data-trigger="fileinput" style="width: 135px; height: 150px;object-fit:cover">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                                    <input class="hak" type="radio" name="default" value="{{$ug['groups_id']}}" disabled="disabled" {{$ug['default'] ? 'checked' : ''}}  {{$ug['status']}}>
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
        @include('component.actions')
    </div>
</div>
</div>
@endsection