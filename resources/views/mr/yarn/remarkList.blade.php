<table style="width: 100%; margin-top: 10px;">
    @foreach ($remarks as $remark)
        <tr>
            <td>
                <input class="form-control" style="height: 25px;padding: 2px; border-radius: 0px !important; font-size: 10px;" onchange="updateRemarks({{$orderId}},{{ $loop->index }})" type="text"  value="{{ $remark }}"id="{{  $loop->index }}remarks">
            </td>
        </tr>
    @endforeach
</table>
<button  style="font-size:12px;" class="btn btn-sm btn-primary mb-2 mt-2 py-0" id="addNewFebric" onclick="remarksList(true)">Add New Remarks</button>
