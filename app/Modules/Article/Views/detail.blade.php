@extends('layouts.layout')

@section('content')

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
                            <td width="150px">Article Category</td>
                            <td>:</td>
                            <td>{{ isset($data->article_category->name)? $data->article_category->name : '' }}</td>
                        </tr>
                        <tr>
                            <td>Title</td>
                            <td>:</td>
                            <td>{{ isset($data->title)? $data->title : '' }}</td>
                        </tr>
                        <tr>
                            <td>Article Date</td>
                            <td>:</td>
                            <td>{{ isset($data->date)? dateToIndo($data->date) : '' }}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>:</td>
                            <td>{{ isset($data->desc)? $data->desc : '' }}</td>
                        </tr>
                        <tr>
                            <td>Ordering</td>
                            <td>:</td>
                            <td>{{ isset($data->sequence)? $data->sequence : '' }}</td>
                        </tr>
                        <tr>
                            <td>Status Publish</td>
                            <td>:</td>
                            <td>{{ $data->is_publish == 1? 'Publish' : 'Draft' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                        <tr>
                            <td width="150px">Photo Product</td>
                            <td>:</td>
                            <td>
                                @if(isset($data->photo) && $data->photo != '')
                                    <div class="fileinput-preview img-thumbnail text-center" data-trigger="fileinput" style="width: 135px; height: 150px;object-fit:cover">
                                        <img src="{{ asset($data->photo) }}">
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
        @include('component.actions')
    </div>
</div>
</div>
@endsection