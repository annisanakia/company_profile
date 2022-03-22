@if(Session::has('msg'))
<div class="alert alert-success text-center" id="hideMe">
    {!! Session::get('msg') !!}
</div>
@endif
<div class="card">
<div class="card-body">
    <div class="title-form">
        List Company Quality
    </div>
    <div class="block-form">
        @if ($priv['edit_priv'])
        <div class="text-right">
            <a class="btn btn-click btn-navy responsive edit-button"
                href="{{url($controller_name.'/editQuality')}}"
                data-target="#container">
                <i class="fa-regular fa-square-plus" style="font-size: 15px"></i>
                Add Quality
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
                    @if (count($company_qualitys) <= 0)
                        <tr>
                            <td colspan="5" style="text-align: center">Data Tidak Ditemukan</td>
                        </tr>
                    @else
                        @php ($i = 0) @endphp
                        @foreach ($company_qualitys as $data)
                        <tr>
                            <td>{{ ++$i}}</td>
                            <td>{{ isset($data->name) ? $data->name : ''}}</td>
                            <td>{{ isset($data->sequence) ? $data->sequence : ''}}</td>
                            <td>{{ $data->is_publish == 1? 'Publish' : 'Draft'}}</td>
                            <td class="action-list text-center">
                                @if ($priv['edit_priv'])
                                    <a href="{{ route($controller_name.'.editQuality',['id'=>$data->id]) }}" class="green edit-button" data-target="#container">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                @endif
                                @if ($priv['delete_priv'])
                                    <a href="{{ route($controller_name.'.deleteQuality',['id'=>$data->id]) }}" class="red delete-data" ng-click="confirm($event)">
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