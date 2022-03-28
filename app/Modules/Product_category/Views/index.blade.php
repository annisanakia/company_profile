@extends('layouts.table')

@section('content_table')
<div class="title-table">
    {{$title}}
</div>

<div id="container" class="detail-content" ng-controller="containerController">
    @include(ucwords($controller_name).'::list')
</div>
@endsection