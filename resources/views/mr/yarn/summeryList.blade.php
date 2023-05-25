@php
    // dd($summery);
@endphp
<style>

    table{
        font-size: 10px;
    }

    td{
        padding: 0px !important;
        margin: 0px !important;
        border: 1px solid #000;
        text-align: center;
    }

    .table-input{
        border: 0;
        width: 100%;
        text-align: center;
        margin: 0px;
        padding: 0px;
        text-align: center;
    }
</style>

<table style="margin-top: 10px;">
    <tbody>
        @if(count($summeries))
            <tr>
                <td>Item</td>
                <td>Fabrica</td>
                <td>Qty(kg)</td>
            </tr>
        @endif
        @for ($i=0; $i<count($summeries); $i++)
        <tr>
            <td style="border: 1px solid #000; ">
                <div style="text-align: center;">
                        <textarea
                        onmouseup="changeSummeryTextAreaHight({{$i}}, 'item')"
                        onchange="updateSummery({{$i}})"
                        onkeyup="resizeSummeryRealTime(this, {{$i}}, 'item')"
                        id="summery{{$i}}-item" name="summery{{$i}}"
                        class="table-input summeryInput" style="height: 19px; width: 100% !important;">{{ $summeries[$i][0] }}</textarea>
                </div>
            </td>
            <td style="border: 1px solid #000; ">
                <div style="text-align: center;">
                    <textarea
                    onmouseup="changeSummeryTextAreaHight({{$i}}, 'fabric')"
                    onchange="updateSummery({{$i}})"
                    onkeyup="resizeSummeryRealTime(this, {{$i}}, 'fabric')"
                    id="summery{{$i}}-fabric" class="textArea summeryInput"
                    name="summery{{$i}}"
                    style="height: 19px; width: 100%;border: 0; text-align: center;">{{ $summeries[$i][1] }}</textarea>
                </div>
            </td>
            <td style="border: 1px solid #000; ">
                <div style="text-align: center; ">
                    <textarea
                    onmouseup="changeSummeryTextAreaHight({{$i}}, 'qty')"
                    onchange="updateSummery({{$i}})"
                    onkeyup="resizeSummeryRealTime(this, {{$i}}, 'qty')"
                    id="summery{{$i}}-qty"
                    type="text" name="summery{{$i}}"
                    class="table-input summeryInput"
                    style="height: 19px; width: 100% !important;">{{ $summeries[$i][2] }}</textarea>
                </div>
            </td>
        </tr>
        @endfor
    </tbody>
</table>


<button  style="font-size:12px;" class="btn btn-sm btn-primary mb-2 mt-2 py-0" id="addNewFebric" onclick="getSummery(true)">Add New</button>


<script>
    function changeSummeryTextAreaHight(id, tag){
        let  ele = document.getElementById('summery'+id+'-'+tag);
        let height = getComputedStyle(ele)['height'];
        let  item = document.getElementById('summery'+id+'-item');
        let  fabric = document.getElementById('summery'+id+'-fabric');
        let  qty = document.getElementById('summery'+id+'-qty');
        item.style.height = height;
        fabric.style.height = height;
        qty.style.height = height;
    }

    function resizeSummeryRealTime(ele,id, row){
            ele.style.height = 0 +"px";
            ele.style.height = (ele.scrollHeight) + 'px';
            changeSummeryTextAreaHight(id, row);
    }
</script>
