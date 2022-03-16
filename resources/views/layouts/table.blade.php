@extends('layouts.layout')

@section('content')

<div class="page-content-detail">
    @yield('content_table')
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/js/scrollBack.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/js/tableAngular.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/js/deleteRows.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/js/publishRow.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.lang.en.js')}}" type="text/javascript"></script>
@stop