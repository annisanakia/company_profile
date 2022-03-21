@extends('layouts.layout')

@section('content')

<div class="title-table">
    {{$title}}
</div>

<div class="tab-wizard tab-ajax-navigation">
    <!-- Nav tabs -->
    <ul class="nav nav-pills nav-fill">
        <li role="presentation" class="nav-item">
            <a id="company_information" href="{{url($controller_name.'/company_information')}}" data-formUrl=""
                class="nav-link active" data-target="#container" data-toggle="tabajax" aria-controls="identitas" role="tab">
                Company Information
            </a>
        </li>
        <li role="presentation" class="nav-item">
            <a id="company_team" href="{{url($controller_name.'/company_team')}}" data-formUrl=""
                class="nav-link" data-target="#container" data-toggle="tabajax" aria-controls="identitas" role="tab">
                Company Team
            </a>
        </li>
        <li role="presentation" class="nav-item">
            <a id="header_config" href="{{url($controller_name.'/header_config')}}" data-formUrl=""
                class="nav-link" data-target="#container" data-toggle="tabajax" aria-controls="identitas" role="tab">
                Header Configuration
            </a>
        </li>
        <li role="presentation" class="nav-item">
            <a id="other_information" href="{{url($controller_name.'/other_information')}}" data-formUrl=""
                class="nav-link" data-target="#container" data-toggle="tabajax" aria-controls="identitas" role="tab">
                Other Information
            </a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="container" ng-controller="containerController">
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        function getTab(element) {
            var $this = $(element),
                    loadurl = $this.attr('href'),
                    targ = $this.attr('data-target'),
                    active = $this.attr('data-active');

            if (active !== 'disabled') {
                $(targ).append('<div class="loader"><img src="/assets/images/preloader.svg"/></div>');

                $.get(loadurl, function (data) {
                    var scope = angular.element(targ).scope();
                    scope.compiled(data, targ);
                    scope.$apply();
                });

                $this.tab('show');
            }
        }

        getTab('.tab-ajax-navigation .nav-pills .nav-item a.active');

        $(function () {
            $('[data-hover="tooltip"]').tooltip()
        });

        $('[data-toggle="tabajax"]').click(function (e) {
            getTab(this);
            return false;
        });

        $('#delete-this').unbind().click(function (e) {
            var $this = $(this),
                    url = $this.attr('href');

            $.get(url, function (data) {
                var scope = angular.element('#container').scope();
                scope.compiled(data, '#container');
                scope.$apply();
                $('.deleteConfirm').modal('hide');
            });

            return false;
        });
    });

    function setPage(element, target, currentTab) {
        var url = $(element).data('url'),
                id = $(element).data('id');

        $(target).append('<div class="loader"><img src="/assets/images/preloader.svg"/></div>');

        $.ajax({
            url: url,
            data: {id: id},
            success: function (e) {
                var scope = angular.element(target).scope();
                scope.compiled(e, target);
                scope.$apply();
                $(currentTab).tab('show');
            }
        });
        scrollBack(".tab-wizard");
    }
</script>

<script src="{{ asset('assets/js/scrollBack.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.lang.id.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/js/deleteRows.js')}}" type="text/javascript"></script>

@endsection

@section('scripts')
@parent
<script src="{{ asset('assets/js/tableAngular.js')}}" type="text/javascript"></script>
@stop