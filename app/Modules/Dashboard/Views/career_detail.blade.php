<div class="modal-header">
    <h5 class="modal-title" id="getModal">{{ isset($data->name)? $data->name : '' }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    @if($data->photo != '')
        <img class="modal-img mb-3" src="{{ isset($data->photo)? $data->photo : '' }}">
    @endif
    
    <div class="detail-title mb-3 text-center">
        <h4 class="font-weight-bold mb-1 color-orange mx-auto">{{ $data->name }}</h4>
        <span class="f-14">
            {{ dateToIndo($data->start_date) }} - {{ dateToIndo($data->end_date) }}
        </span>
    </div>
    <div class="font-weight-bold mt-2">Job Description</div>
    {!! $data->desc !!}
    <div class="font-weight-bold mt-2">Qualification</div>
    {!! $data->qualification !!}
</div>