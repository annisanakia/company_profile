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
                            <td width="150px">Name</td>
                            <td width="10px">:</td>
                            <td>{{ isset($data->name)? $data->name : '' }}</td>
                        </tr>
                        <tr>
                            <td>Link</td>
                            <td width="10px">:</td>
                            <td>{{ isset($data->slug)? $data->slug : '' }}</td>
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
                            <td width="150px">Publish</td>
                            <td width="10px">:</td>
                            <td>{{ $data->display == 1 ? 'Publish' : 'Draft' }}</td>
                        </tr>
                        <tr>
                            <td>Component Type</td>
                            <td width="10px">:</td>
                            @php
                                $components = getComponentType();
                            @endphp
                            <td>{{ array_key_exists($data->component_type,$components)? $components[$data->component_type] : '' }}</td>
                        </tr>
                        @if($data->component_link != '')
                        <tr>
                            <td>Component Link</td>
                            <td width="10px">:</td>
                            <td>{{ $data->component_type != 6? (array_key_exists($data->component_link,getComponentType())? getComponentType()[$data->component_link] : '') : $data->component_link }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td>Icon</td>
                            <td width="10px">:</td>
                            <td>{{ isset($data->icon)? $data->icon : '' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @include('component.actions')
    </div>
</div>
</div>

@endsection