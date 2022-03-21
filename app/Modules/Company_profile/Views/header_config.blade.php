
<div class="row">
    <div class="col-md-6">
        <div class="card">
        <div class="card-body">
            <div class="title-form">
                Main Header
            </div>
            <div class="block-form">
                @if ($priv['edit_priv'])
                <div class="text-right">
                    <a class="btn btn-click btn-navy responsive edit-button"
                        href="{{url($controller_name.'/addMainHeader')}}"
                        data-target="#container">
                        <i class="fa-regular fa-square-plus" style="font-size: 15px"></i>
                        Add Main Header
                    </a>
                </div>
                @endif
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
        <div class="card-body">
            <div class="title-form">
                Profil Header
            </div>
            <div class="block-form">
                @if ($priv['edit_priv'])
                <div class="text-right">
                    <a class="btn btn-click btn-purple responsive edit-button"
                        href="{{url($controller_name.'/editProfileHeader')}}"
                        data-target="#container">
                        <i class="fa-solid fa-pencil" style="font-size: 15px"></i>
                        Edit Profile Header
                    </a>
                </div>
                @endif
            </div>
        </div>
        </div>
        <div class="card">
        <div class="card-body">
            <div class="title-form">
                Product Header
            </div>
            <div class="block-form">
                @if ($priv['edit_priv'])
                <div class="text-right">
                    <a class="btn btn-click btn-purple responsive edit-button"
                        href="{{url($controller_name.'/editProductHeader')}}"
                        data-target="#container">
                        <i class="fa-solid fa-pencil" style="font-size: 15px"></i>
                        Edit Product Header
                    </a>
                </div>
                @endif
            </div>
        </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.edit-button').click(function (e) {
            e.preventDefault();
            var $this = $(this),
                    loadurl = $this.attr('href'),
                    targ = $this.attr('data-target');
            
            $(targ).append('<div class="loader"><img src="/assets/images/preloader.svg"/></div>');

            $.get(loadurl, function (data) {
                $(targ).html(data);
            });

            return false;
        });
    });
</script>

<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.css')}}">
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>