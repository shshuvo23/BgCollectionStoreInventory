@foreach ($remarks as $remark)
    <input class="form-control" style="font-size: 12px;margin-bottom:10px" onchange="updateRemarks(1,{{ $loop->index }})" type="text"  value="{{ $remark }}"
    id="{{  $loop->index }}remarks">
@endforeach
<button  style="font-size:12px;" class="btn btn-sm btn-primary mb-2" id="addNewFebric" onclick="remarksList(true)">Add New Remarks</button>
