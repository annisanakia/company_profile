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
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                        <tr>
                            <td width="150px">Code</td>
                            <td width="10px">:</td>
                            <td>{{ isset($data->code)? $data->code : '' }}</td>
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