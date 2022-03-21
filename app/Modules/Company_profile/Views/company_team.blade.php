{{ Form::model($param, array('route' => $controller_name.'.company_team', 'ng-controller'=>'formController', 'ng-submit'=>'submit($event)', 'data-target'=>'#container3', 'id'=>'form-modal-ajax')) }}

@if(Session::has('msg'))
<div class="alert alert-success text-center" id="hideMe">
    {!! Session::get('msg') !!}
</div>
@endif
<div class="card">
<div class="card-body">
    <div class="title-form">
        List Company Team
    </div>
    <div class="block-form">
        @if ($priv['edit_priv'])
        <div class="text-right">
            <a class="btn btn-click btn-navy responsive edit-button"
                href="{{url($controller_name.'/editTeam')}}"
                data-target="#container">
                <i class="fa-regular fa-square-plus" style="font-size: 15px"></i>
                Add New Team
            </a>
        </div>
        @endif
        <div class="table-list">
            <table class="table table-check" data-tablesaw-mode="columntoggle">
                <thead>
                    <tr class="ordering">
                        <th width="10px">No</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($datas) <= 0)
                        <tr>
                            <td colspan="3" style="text-align: center">{{ say('Data Tidak Ditemukan') }}</td>
                        </tr>
                    @else
                        @php ($i = 0) @endphp
                        @foreach ($datas as $data)
                        <tr>
                            <td>{{ (($datas->currentPage() - 1) * $datas->perPage()) + ++$i}}</td>
                            <td>{{ isset($data->name) ? $data->name : ''}}</td>
                            <td>{{ isset($data->role) ? $data->role : ''}}</td>
                            <td class="action-list text-center">
                                @if ($priv['edit_priv'])
                                    <a href="{{ route($controller_name.'.editTeam',['id'=>$data->id]) }}" class="green edit-button" data-target="#container">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                @endif
                                @if ($priv['delete_priv'])
                                    <a href="{{ route($controller_name.'.deleteTeam',['id'=>$data->id]) }}" class="red delete-data" ng-click="confirm($event)">
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
        <div class="table-list-footer">
            <span class="result-count">Showing {{$datas->firstItem()}} to {{$datas->lastItem()}} of {{$datas->total()}} entries</span>
            {{ $datas->appends($param)->links('component.pagination')}}
        </div>
    </div>
</div>
{{ Form::close() }}

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