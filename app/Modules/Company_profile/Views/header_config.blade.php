<style>
    .table-img.ava .preview-img {
        height: 70px;
        width: 113px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
        <div class="card-body">
            <div class="title-form">
                Main Header
            </div>
            <div class="block-form">
                @if ($priv['edit_priv'])
                <div class="text-right">
                    <a class="btn btn-click btn-navy responsive edit-button"
                        href="{{url($controller_name.'/editHeader?code=main_header')}}"
                        data-target="#container">
                        <i class="fa-regular fa-square-plus" style="font-size: 15px"></i>
                        Add Main Header
                    </a>
                </div>
                @endif
                <div class="table-list">
                    <table class="table table-check" data-tablesaw-mode="columntoggle">
                        <thead>
                            <tr class="ordering">
                                <th width="10px">No</th>
                                <th>Name</th>
                                <th>Ordering</th>
                                <th>Status Publish</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($main_headers) <= 0)
                                <tr>
                                    <td colspan="5" style="text-align: center">Data Tidak Ditemukan</td>
                                </tr>
                            @else
                                @php ($i = 0) @endphp
                                @foreach ($main_headers as $data)
                                <?php
                                    $data_content = isset($data->data_content)? $data->data_content : $data;
                                ?>
                                <tr>
                                    <td>{{ ++$i}}</td>
                                    <td nowrap>
                                        <table class="table-img ava">
                                            <tr>
                                                <td width="85px">
                                                    @if(isset($data_content->photo) && ($data_content->photo != ''))
                                                        <div class="preview-img">
                                                            <img src="{{ asset($data_content->photo) }}" class="img-cover">
                                                        </div>
                                                    @else
                                                        <div class="preview-img">
                                                            <i class="fas fa-camera"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ isset($data_content->name)? $data_content->name : '' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>{{ isset($data->sequence) ? $data->sequence : ''}}</td>
                                    <td>
                                        @php
                                            switch ($data->is_publish) {
                                                case 1:
                                                    $bg = 'bg-green';
                                                    break;
                                                default:
                                                    $bg = 'bg-red';
                                            }
                                        @endphp
                                        <span class="{{$bg}} bg-label">
                                            {{ $data->is_publish == 1 ? 'Publish' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td class="action-list text-center">
                                        @if ($priv['edit_priv'])
                                            <a href="{{ route($controller_name.'.editHeader',['id'=>$data->id,'code'=>'main_header']) }}" class="green edit-button" data-target="#container">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        @endif
                                        @if ($priv['delete_priv'])
                                            <a href="{{ route($controller_name.'.deleteHeader',['id'=>$data->id]) }}" class="red delete-data" ng-click="confirm($event)">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
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
                        href="{{url($controller_name.'/editHeader?code=profile_header&id='.(isset($profile_header)? $profile_header->id  :''))}}"
                        data-target="#container">
                        <i class="fa-solid fa-pencil" style="font-size: 15px"></i>
                        Edit Profile Header
                    </a>
                </div>
                @endif
                <div class="table-list">
                    <table class="table table-check" data-tablesaw-mode="columntoggle">
                        <tbody>
                            @if (isset($profile_header) <= 0)
                                <tr>
                                    <td colspan="5" style="text-align: center">Header belum disetting</td>
                                </tr>
                            @else
                                <?php
                                    $data = $profile_header;
                                    $data_content = isset($data->data_content)? $data->data_content : $data;
                                ?>
                                <tr>
                                    <td nowrap>
                                        <table class="table-img ava">
                                            <tr>
                                                <td width="85px">
                                                    @if(isset($data_content->photo) && ($data_content->photo != ''))
                                                        <div class="preview-img">
                                                            <img src="{{ asset($data_content->photo) }}" class="img-cover">
                                                        </div>
                                                    @else
                                                        <div class="preview-img">
                                                            <i class="fas fa-camera"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ isset($data_content->name)? $data_content->name : '' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
        <div class="card-body">
            <div class="title-form">
                Product Header
            </div>
            <div class="block-form">
                @if ($priv['edit_priv'])
                <div class="text-right">
                    <a class="btn btn-click btn-purple responsive edit-button"
                        href="{{url($controller_name.'/editHeader?code=product_header&id='.(isset($product_header)? $product_header->id  :''))}}"
                        data-target="#container">
                        <i class="fa-solid fa-pencil" style="font-size: 15px"></i>
                        Edit Product Header
                    </a>
                </div>
                @endif
                <div class="table-list">
                    <table class="table table-check" data-tablesaw-mode="columntoggle">
                        <tbody>
                            @if (isset($product_header) <= 0)
                                <tr>
                                    <td colspan="5" style="text-align: center">Header belum disetting</td>
                                </tr>
                            @else
                                <?php
                                    $data = $product_header;
                                    $data_content = isset($data->data_content)? $data->data_content : $data;
                                ?>
                                <tr>
                                    <td nowrap>
                                        <table class="table-img ava">
                                            <tr>
                                                <td width="85px">
                                                    @if(isset($data_content->photo) && ($data_content->photo != ''))
                                                        <div class="preview-img">
                                                            <img src="{{ asset($data_content->photo) }}" class="img-cover">
                                                        </div>
                                                    @else
                                                        <div class="preview-img">
                                                            <i class="fas fa-camera"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ isset($data_content->name)? $data_content->name : '' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
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