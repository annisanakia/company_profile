<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <?php
            $title = 'PINTRO';
            $menuComposer = new \Lib\core\menuComposer();
        ?>

        <link rel="icon" href="{{ asset('assets/images/templates/favicon.png') }}">
        <title>{{$title}}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/icheck/skins/flat/_all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/layout/layout.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/datetimepicker/jquery.datetimepicker.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/tablesaw/tablesaw.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-lite.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/main.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/datetimepicker/datetimepicker.min.css')}}"/>
        @yield('styles')
        
        <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('assets/js/jquery-form.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/angular.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/utterscroll/jquery-scrollable.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/popper.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.js')}}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
        <script src="https://kit.fontawesome.com/31c8d4e018.js" crossorigin="anonymous"></script>
    </head>
    <body class="menu-vertical menu-expanded">
        <nav class="navbar navbar-top">
            <ul class="navbar-nav d-inline float-right">
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="{{ url('account') }}">
                        <i class="fas fa-user-circle" style="color:#177584"></i>
                    </a> 
                </li>
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fas fa-power-off" style="color:#a80c2f"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <div class="container-fluid">
            <nav class="sidebar navbar-side">
                <div class="side-header">
                    <a class="navbar-toggle" href="#">
                        <i class="fas fa-align-right" aria-hidden="true"></i>
                    </a>
                    <img class="side-logo" src="{{ asset('assets/images/logo-white.png') }}">
                </div>
                <div class="sidebar-sticky">
                    @if(!is_array($menuComposer->compose()))
                        {!! $menuComposer->compose() !!}
                    @endif
                </div>
            </nav>
            @yield('content_app')
        </div>
        <footer class="footer">
        </footer>
        <script src="{{asset('assets/js/app.js')}}"></script>
        <script src="{{ asset('assets/plugins/icheck/icheck.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/plugins/layout/layout.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/plugins/utterscroll/debiki-utterscroll.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/plugins/modernizr/modernizr-custom.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/plugins/tablesaw/tablesaw.jquery.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/plugins/tablesaw/tablesaw-init.js')}}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/summernote/summernote-lite.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/js/moment.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/datetimepicker/datetimepicker.min.js')}}"></script>
        <script type="text/javascript">
        var showApp = angular.module('myApp', []);
        showApp.controller('actionController', function ($scope) {
            $scope.confirm = function ($event) {
                $event.preventDefault();
                $('.deleteConfirm').modal('show');
                $('.deleteConfirm #delete-this').attr("href", $event.target.href);

                $button = angular.element($event.target);
                $target = $button.data('target');

                $('.deleteConfirm #delete-this').attr("data-target", $target);
            }
        });

        $(document).ready(function () {
            jQuery(function ($) {
                // Here, could test if this is a touch device with not mouse, and, if so, don't enable.
                debiki.Utterscroll.enable({
                    scrollstoppers: '.note-editor, .note-editing-area, .un-drag'});
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(function () {
                if (!Modernizr.inputtypes.date) {
                    $.getScript("/assets/plugins/jquery-ui/jquery-ui.min.js");
                    // If not native HTML5 support, fallback to jQuery datePicker
                    $('input[type=date]').datepicker({
                        // Consistent format with the HTML5 picker
                        dateFormat: 'dd-mm-yy'
                    },
                    // Localization
                    $.datepicker.regional['id']
                            );
                }
                if (!Modernizr.inputtypes['datetime-local']) {
                    $.getScript("/assets/plugins/datetimepicker/jquery.datetimepicker.full.min.js");
                    $('input[type=datetime-local]').datetimepicker();
                }
            });

            $('body').on('click', '.expand-full', function () {
                if ($(this).data('full') == false) {
                    $('.page-content-detail').addClass('fullscreen');
                    $(this).html('<i class="fa fa-compress" aria-hidden="true"></i>');
                    $(this).data('full', true);
                } else {
                    $('.page-content-detail').removeClass('fullscreen');
                    $(this).html('<i class="fa fa-expand" aria-hidden="true"></i>');
                    $(this).data('full', false);
                }
            });

            $('body').on('click', '.collapse-panel', function () {
                if ($(this).data('full') == false) {
                    $(this).parents('.panel').find('.panel-body').addClass('hidden');
                    $(this).html('<i class="fa fa-angle-up" aria-hidden="true"></i>');
                    $(this).data('full', true);
                } else {
                    $(this).parents('.panel').find('.panel-body').removeClass('hidden');
                    $(this).html('<i class="fa fa-angle-down" aria-hidden="true"></i>');
                    $(this).data('full', false);
                }
            });

            function ajax_switch($url, $data) {
                $.ajax({
                    type: 'get',
                    url: $url,
                    data: {id: $data}
                }).done(function (data) {
                    location.reload();
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    alert('No response from server');
                });
            }

            $('#group select').on('change', function () {
                //console.log($(this).val());
                ajax_switch('{{url("groups/changeGroup")}}', $(this).val());
            });

            $('#accal select').on('change', function () {
                //console.log($(this).val());
                ajax_switch('{{url("groups/changeAccal")}}', $(this).val());
            });

            function get_notif() {
                var url = "{{url('notification/get_notif_appl')}}";

                $.ajax({
                    type: 'get',
                    url: url,
                }).done(function (data) {
                    $('#header_notification_bar').html(data);
                    console.log('New notif');
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Terjadi Kesalahan');
                });
            }
        });

        $(document).ajaxError(function () {
            $('.loader').remove();
            console.log('Terjadi Kesalahan');
        });
    </script>
    @yield('scripts')
    </body>
</html>