{{ Form::model($param, array('route' => $controller_name.'.search', 'ng-controller'=>'formController', 'ng-submit'=>'submit($event)')) }}
<style>
    table.no-style tr td{
        padding:0;
        border:0 !important
    }
</style>

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
                <th ng-controller="sortController" data-tablesaw-priority="1">{{ link_to_route($controller_name.'.search', 'Career Type', array('sort_field'=> 'career_type_id'), array('ng-model'=>'sort_type', 'ng-click'=>'sort($event, sort_type)'))}}</th>
                <th ng-controller="sortController" data-tablesaw-priority="1">{{ link_to_route($controller_name.'.search', 'Name', array('sort_field'=> 'name'), array('ng-model'=>'sort_type', 'ng-click'=>'sort($event, sort_type)'))}}</th>
                <th ng-controller="sortController" data-tablesaw-priority="1">{{ link_to_route($controller_name.'.search', 'Date Job Vacancy', array('sort_field'=> 'start_date'), array('ng-model'=>'sort_type', 'ng-click'=>'sort($event, sort_type)'))}}</th>
                <th ng-controller="sortController" data-tablesaw-priority="1">{{ link_to_route($controller_name.'.search', 'Status Publish', array('sort_field'=> 'is_publish'), array('ng-model'=>'sort_type', 'ng-click'=>'sort($event, sort_type)'))}}</th>
                <th data-tablesaw-priority="1" class="text-center">Action</th>
            </tr>
            <tr>
                <th>{{ Form::checkbox('group_row', null, null, array('class'=>'group_check iCheck', 'data-set'=>'.table-check .checkboxes')) }}</th>
                <th><button type="submit"><i class="fas fa-search"></i></span></button></th>
                <th>{{ Form::select('filter[career_type_id]', [''=>'']+\Models\career_type::pluck('name','id')->all()) }}</th>
                <th>{{ Form::text('filter[name]') }}</th>
                <th>
                    <table class="no-style">
                        <tr>
                            <td>From</td>
                            <td width="5px">:</td>
                            <td>{{ Form::date('filter[start_date]') }}</td>
                        </tr>
                        <tr>
                            <td>To</td>
                            <td width="5px">:</td>
                            <td>{{ Form::date('filter[end_date]') }}</td>
                        </tr>
                    </table>
                </th>
                <th>{{ Form::select('filter[is_publish]', [''=>'',2=>'Draft',1=>'publish']) }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if (count($datas) <= 0)
                <tr>                         
                    <td colspan="7" style="text-align: center">{{ 'Data Tidak Ditemukan' }}</td> 
                </tr>
            @else
                @php
                    $i = 0
                @endphp
                @foreach ($datas as $data)
                <tr>
                    <td>{{ Form::checkbox('select_row[]', $data->id, null, array('class'=>'checkboxes iCheck')) }}</td>
                    <td>{{ (($datas->currentPage() - 1 ) * $datas->perPage() ) + ++$i }}</td>
                    <td>{{ isset($data->career_type->name)? $data->career_type->name : '' }}</td>
                    <td nowrap>
                        <table class="table-img ava">
                            <tr>
                                <td width="85px">
                                    @if(isset($data->photo) && ($data->photo != ''))
                                        <div class="preview-img">
                                            <img src="{{ asset($data->photo) }}" class="img-cover">
                                        </div>
                                    @else
                                        <div class="preview-img">
                                            <i class="fas fa-camera"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    {{ isset($data->title)? $data->title : '' }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        {{ isset($data->start_date)? dateToIndo($data->start_date) : 'NA' }} -
                        {{ isset($data->end_date)? dateToIndo($data->end_date) : 'NA' }}
                    </td>
                    <td>{{ $data->is_publish == 1? 'Publish' : 'Draft' }}</td>
                    <td ng-controller="actionController" class="action-list text-center" nowrap>
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
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-fileinput/css/jasny-bootstrap.min.css')}}"/>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-fileinput/js/jasny-bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/js/actions.js')}}" type="text/javascript"></script>
<script type="text/javascript">  
    $(document).trigger('enhance.tablesaw');
</script>