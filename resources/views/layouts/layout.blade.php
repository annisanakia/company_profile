@php

$users = \App\User::find(Auth::user()->id);
$users_photo = \Models\users_photo::where('users_id',Auth::user()->id)->first();
$department_level = isset($users->ng_department->ng_department_level->code) ? $users->ng_department->ng_department_level->code : null;
$layout = 'layouts.app';

@endphp

@extends($layout)
@section('content_app')
    @php
        $menuComposer = new \Lib\core\menuComposer();
        $menucontent = $menuComposer->compose2();
        $segment = $menuComposer->getSegment();
    @endphp
    <div class="container-content" ng-app="myApp">
        @yield('content')
    </div>

    <div class="modal fade modalConfirm publishConfirm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-card" role="document">
            <span class="close" data-dismiss="modal">X</span>
            <div class="modal-content">
                <div class="modal-header">    
                    Publish Article?
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan mempublish article ini?
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-click btn-grey responsive" data-dismiss="modal">Cancel</button>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="#" id="publish-this"><button type="button" class="btn btn-click btn-red responsive">Publish</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modalConfirm deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-card" role="document">
            <span class="close" data-dismiss="modal">X</span>
            <div class="modal-content">
                <div class="modal-header">    
                    Hapus Data?
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan menghapus data ini?
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-click btn-grey responsive" data-dismiss="modal">Cancel</button>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="#" id="delete-this"><button type="button" class="btn btn-click btn-red responsive">Hapus</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            var menuTop = $('.page-top-menu');
            var url = location.href.toLowerCase();
            menuTop.find("li > a").each(function () {
                var path = $(this).attr("href").toLowerCase();
                if ($(this).parent('li').hasClass('active')) {
                    $(this).closest('.dropdown').addClass('active');
                }
            });
            var url = $("ul.nav.navbar-nav.page-top-menu").find("li").first().find("a").attr("href");
            var segment = '{{$segment[0]}}';
            var is_excuted = false;
            if (segment == "blank" && is_excuted == false) {
                is_excuted = true;
                $.ajax({
                    cache: false,
                    url: url,
                    success: function (data) {
                        window.location.href = url;
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        if (xhr.status == 404) {

                        }
                    }
                });
            }
        });
    </script>   
@endsection