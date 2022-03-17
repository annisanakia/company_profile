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
                <table class="table">
                    <tbody>
                        <tr>
                            <td width="150px">Code</td>
                            <td width="10px">:</td>
                            <td>{{ isset($data->code)? $data->code : '' }}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td width="10px">:</td>
                            <td>{{ isset($data->name)? $data->name : '' }}</td>
                        </tr>
                        <tr>
                            <td>Parent</td>
                            <td width="10px">:</td>
                            <td>{{ isset($data->parents->name)? $data->parents->name : '' }}</td>
                        </tr>
                        <tr>
                            <td>Urutan</td>
                            <td width="10px">:</td>
                            <td>{{ isset($data->ordering)? $data->ordering : '' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Publish</td>
                            <td width="10px">:</td>
                            <td>{{ $data->display == 1 ? 'Publish' : 'Draft' }}</td>
                        </tr>
                        <tr>
                            <td>Tipe Menu</td>
                            <td width="10px">:</td>
                            <td>{{ isset($data->menu_type->name)? $data->menu_type->name : '' }}</td>
                        </tr>
                        <tr>
                            <td>Icon</td>
                            <td width="10px">:</td>
                            <td>{{ isset($data->icon)? $data->icon : '' }}</td>
                        </tr>
                    </tbody>
                </table>
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
                                            <input class="hak" type="checkbox" name="add_priv[{{$ug['groups_id']}}]" value="1" disabled="disabled" {{$ug['add_priv'] ? 'checked' : ''}}  {{$ug['status']}}>
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
                                            <input class="hak" type="checkbox" name="edit_priv[{{$ug['groups_id']}}]" value="1" disabled="disabled" {{$ug['edit_priv'] ? 'checked' : ''}}  {{$ug['status']}}>
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
                                            <input class="hak" type="checkbox" name="remove_priv[{{$ug['groups_id']}}]" value="1" disabled="disabled" {{$ug['remove_priv'] ? 'checked' : ''}}  {{$ug['status']}}>
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

@endsection