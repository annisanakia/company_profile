{{ Form::model($param, array('route' => $controller_name.'.search', 'ng-controller'=>'formController', 'ng-submit'=>'submit($event)')) }}
<a href="{{ url($controller_name) }}" class="linkIndex hidden"></a>

<div class="float-right">
    @include('component.actions')
</div>
<div class="table-list">
    <div class="select-max-row d-inline-block">
        Show 
        {{ Form::text('max_row', $datas->perPage(), array('size'=>4, 'maxlength'=>4)) }} entries
    </div>
    <table class="table table-check" data-tablesaw-mode="columntoggle">
        <thead>
            <tr class="ordering">
                <th width="10px" data-tablesaw-priority="persist">#</th>
                <th width="10px" data-tablesaw-priority="persist" class="text-center">No</th>
                <th ng-controller="sortController" data-tablesaw-priority="1">{{ link_to_route($controller_name.'.search', 'Name', array('sort_field'=> 'name'), array('ng-model'=>'sort_type', 'ng-click'=>'sort($event, sort_type)'))}}</th>
                <th ng-controller="sortController" data-tablesaw-priority="1">{{ link_to_route($controller_name.'.search', 'Link', array('sort_field'=> 'slug'), array('ng-model'=>'sort_type', 'ng-click'=>'sort($event, sort_type)'))}}</th>
                <th ng-controller="sortController" data-tablesaw-priority="1">{{ link_to_route($controller_name.'.search', 'Parent', array('sort_field'=> 'parent'), array('ng-model'=>'sort_type', 'ng-click'=>'sort($event, sort_type)'))}}</th>
                <th ng-controller="sortController" data-tablesaw-priority="0">{{ link_to_route($controller_name.'.search', 'Ordering', array('sort_field'=> 'ordering'), array('ng-model'=>'sort_type', 'ng-click'=>'sort($event, sort_type)'))}}</th>
                <th ng-controller="sortController" data-tablesaw-priority="0">{{ link_to_route($controller_name.'.search', 'Display', array('sort_field'=> 'display'), array('ng-model'=>'sort_type', 'ng-click'=>'sort($event, sort_type)'))}}</th>
                <th data-tablesaw-priority="1" class="text-center">Action</th>
            </tr>
            <tr>
                <th>{{ Form::checkbox('group_row', null, null, array('class'=>'group_check iCheck', 'data-set'=>'.table-check .checkboxes')) }}</th>
                <th><button type="submit"><i class="fas fa-search"></i></span></button></th>
                <th>{{ Form::text('filter[name]') }}</th>
                <th>{{ Form::text('filter[slug]') }}</th>
                <th>{{ Form::select('filter[parent]', ([''=>''] + Models\job::nestedSelect())) }}</th>
                <th>{{ Form::text('filter[ordering]') }}</th>
                <th>{{ Form::select('filter[display]', ([''=>''] + array(1=>'Publish', 2=>'Draft'))) }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if (count($datas) <= 0)
                <tr>                         
                    <td colspan="9" style="text-align: center">{{ 'Data Tidak Ditemukan' }}</td> 
                </tr>
            @else
                @php $i = 0 @endphp
                @foreach ($datas as $data)
                <tr>
                    <td>{{ Form::checkbox('select_row[]', $data->id, null, array('class'=>'checkboxes iCheck')) }}</td>
                    <td>{{ (($datas->currentPage() - 1 ) * $datas->perPage() ) + ++$i }}</td>
                    <td>{{ isset($data->name)? $data->name : '' }}</td>
                    <td>{{ isset($data->slug)? $data->slug : ''}}</td>
                    <td>{{ isset($data->parents) ? $data->parents->name : '' }}</td>
                    <td>{{ isset($data->ordering)? $data->ordering : '' }}</td>
                    <td>{{ $data->display == 1 ? 'Publish' : 'Draft' }}</td>
                    <td ng-controller="actionController" class="action-list" nowrap>
                        @if ($priv['edit_priv'])
                            <a href="{{ route($controller_name.'.edit',[$data->id]) }}" class="green">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        @endif
                        <a href="{{ route($controller_name.'.detail',[$data->id]) }}" class="yellow">
                            <i class="fas fa-list-alt"></i>
                        </a>
                        @if ($priv['delete_priv'])
                            <a href="{{ route($controller_name.'.delete',[$data->id]) }}" class="red delete-data" ng-click="confirm($event)">
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

{{ Form::close() }}

@include('layouts.actions')

<script src="{{ asset('assets/js/actions.js')}}" type="text/javascript"></script>
<script type="text/javascript">  
    $(document).trigger('enhance.tablesaw');
</script>