@php
    $dashboard = true;
@endphp
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
<style>
    /* html { overflow: hidden!important; } */
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

      input[type=checkbox]{
          cursor: pointer;
      }

    /* Chrome, Safari, Edge, Opera */
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
      }

      /* Firefox */
      input[type=number] {
      -moz-appearance: textfield;
      }

      div.scroll {
              width: 100%;
              overflow-x: auto;
              overflow-y: hidden;
              white-space: nowrap;
      }
  </style>
@endsection

@section('content')

@php
    $col = count($fabrications);
    $row = count($combos);
    $col2 = 11+($col*2);
    $title = ['Fabrication:', 'Item:', 'Fabrics For:', 'Finished Cos/Dzn:', 'Req Finished GSM:', 'Req Finished DIA:', 'Allocated Yarn Count:', 'Process Loss:'];
    $fabricationColums = ['fabrication','item','fabric_for', 'cos_dzn', 'gsm', 'dia', 'yarn_count', 'process_loss'];
    $width = 60;
    $margin = 305;
    $divWidth = ((60*($col2-1)) + 60 + $col2);
@endphp


{{-- 60% CMIA COT 40% Recycled POLISTER FREANCE TREE (3 thread) --}}






   <div class="d-print-none" style="display: flex; justify-content: end;">
        {{-- <a onclick="saveAsPdf()" href="javascript:void(0)">Save</a> --}}
        <a href="{{ route('print_booking_sheet', $orderId) }}" class="btn btn-sm btn-warning text-white shadow-none"
            target="_blank"><i class="fa fa-print"></i> Print</a>
   </div>

   <div id="myTable">
        <div  class="scroll" style="color: black;">
            <div class="ml-3">
                <div style="padding-top: 100px !important; width: {{$divWidth}}px !important;">
                    <div style="margin-left: {{$margin}}px; display: inline-flex; position: relative;">
                    {{-- absolute child --}}
                     <div style="width: 100%; display: block; text-align: center; font-size: 12px; position: absolute; top:-100px; left: 0;">

                        <span style="display: block; font-size: 14px;">BG COLLECTION ltd.</span><br>
                        <span  >Baniarchala, Bhabanipur, Gazipur</span><br>
                        <span >
                            REVISED
                            <span>{{ $yarnBooking->revised }}</span>
                             BULK BOOKING
                        </span><br>
                        {{-- <span >NEED LYCRA SERTIFICATE</span><br> --}}
                        <span style="text-align: center; text-transform:uppercase;">{{$yarnBooking->hrader_text}}</span>

                    </div>
                    <div style="display:inline; font-size: 12px; position: absolute; top:-62px; left: -215px;">
                        <div style="display:inline">
                        <table class="">
                            <tr>
                            <td class="px-2">Buyer: </td>
                            <td>
                                <input style="border:none; outline: none;" readonly type="text" value="{{ $orderInfo->buyer_name}}">
                            </td>
                            </tr>
                            <tr>
                            <td class="px-2">Order No:</td>
                            <td>
                                <textarea id="orderNo" style="border:none; height: 19px !important;" readonly type="text" >{{ $orderInfo->order_no }}</textarea>
                            </td>
                            </tr>
                            <tr>
                            <td class="px-2">Order Qty:</td>
                            <td>
                                <input style="border:none;outline: none;" min="0" step="0.1" type="number" id="order_qty" value="{{ $yarnBooking->order_qty??"" }}" readonly>
                            </td>
                            </tr>
                        </table>
                        </div>
                    </div>
                    <div style="display:inline;font-size: 12px; position: absolute; top:-45px; right:-185px;">
                        <div style="display:inline">
                        <table class="">
                            <tr>
                                <td class="px-2">Issue Date: </td>
                                <td>
                                    <input style="border:none; outline: none;" type="date" value="{{ $yarnBooking->issuing_date??"" }}" id="issuing_date" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2">Shipment Date:</td>
                                <td>
                                    <input style="border:none; outline: none;" type="date" value="{{ $yarnBooking->shipment_date??"" }}" id="shipment_date" readonly>
                                </td>
                            </tr>
                        </table>
                        </div>
                    </div>
                    <table style="width: 100% !important;">
                        <tbody>
                            @for($i=0; $i <8; $i++)
                                <tr>
                                    <td style="border: 1px solid #000; ">
                                        <div style="text-align: center; width: {{$width*3+1}}px !important;">
                                            {{ $title[$i] }}
                                        </div>
                                    </td>
                                    @for ($j=0; $j<$col; $j++)
                                        <td style="border: 1px solid #000; ">
                                            <div style="text-align: center; width: {{$width*2+1}}px !important;">
                                                @if($i==0 || $i == 6 || $i == 2)
                                                    <textarea class="textArea" id="fabric{{$fabrications[$j]['id']}}-{{$fabricationColums[$i]}}"
                                                    name="{{ $fabricationColums[$i] }}"
                                                    style="height: 19px !important; width: 100%;border: 0; text-align: center;" onmouseup="changeTextAreaHight({{$fabrications[$j]['id']}}, '{{ $fabricationColums[$i] }}')" readonly>{{ $fabrications[$j][$fabricationColums[$i]] }}</textarea>
                                                @else
                                                    <input style="outline: none;" id="fabric{{$fabrications[$j]['id']}}-{{$fabricationColums[$i]}}" type="{{ $fabricationColums[$i]=='cos_dzn'? 'number':($fabricationColums[$i]=='gsm'? 'number':($fabricationColums[$i]=='process_loss'? 'number':'text')) }}" value="{{ $fabrications[$j][$fabricationColums[$i]] }}" class="table-input" readonly>
                                                @endif
                                            </div>
                                        </td>
                                    @endfor
                                </tr>
                            @endfor
                    </tbody>
                    </table>
                    </div>
                    <table style="margin-top: 5px;">
                    <tbody>
                        <tr style="padding: 0;">
                            <td>Combo</td>
                            <td>Color</td>
                            <td>LD No</td>
                            <td>Shade</td>
                            <td>O.Qty</td>
                            <td>E.Cut</td>
                            <td>N.Qty</td>
                            @for ($j=0; $j<$col; $j++)
                                <td>R.Fini</td>
                                <td>R.Gray</td>
                            @endfor
                            <td>T.Fini</td>
                            <td>T.Gray</td>
                            <td>R.mrks</td>
                        </tr>
                        @for ($i=0; $i<$row; $i++)
                        @php $yarnAllocations=$combos[$i]['yarnAllocations'];
                            $allocationId=0;
                            $fabricCol=0;
                            $fabricDx=0;
                        @endphp
                        <tr style="padding: 0;">
                            @for ($j=0; $j<$col2; $j++)
                            @if($j==0)
                            @elseif($j <8 || $col2-4<$j)
                                @php $readonly=false;
                                    if($j-1==0) {$comboId="combo" .$combos[$i]['id']."-combo"; $comboColumn="combo" ; $type='text' ; }
                                    if($j-1==1) { $comboId="combo" .$combos[$i]['id']."-color"; $comboColumn="color" ;$type='text' ;}
                                    if($j-1==2) {$comboId="combo" .$combos[$i]['id']."-ld"; $comboColumn="ld_no" ;$type='text' ;}
                                    if($j-1==3) { $comboId="combo" .$combos[$i]['id']."-shade"; $comboColumn="shade" ;$type='text' ;}
                                    if($j-1==4) {$comboId="combo" .$combos[$i]['id']."-qty";$comboColumn="qty" ;$type='number' ;}
                                    if($j-1==5) {$comboId="combo" .$combos[$i]['id']."-ecut"; $comboColumn="extra_cutting" ;$type='number' ;}
                                    if($j-1==6) {$comboId="combo" .$combos[$i]['id']."-nqty"; $comboColumn="new_qty" ;$type='number' ;}
                                    if($j==$col2-3) {$readonly=true;$comboId="combo" .$combos[$i]['id']."-tf"; $comboColumn="total_finished" ;$type='number' ;}
                                    if($j==$col2-2) {$readonly=true;$comboId="combo" .$combos[$i]['id']."-tg"; $comboColumn="total_gray" ;$type='number' ;}
                                    if($j==$col2-1) {$comboId="combo" .$combos[$i]['id']."-rmk"; $comboColumn="remarks" ;$type='text' ;}
                                @endphp
                                <td>
                                    <div style="text-align: center; width: {{$j==2? $width*2:$width}}px !important;">
                                        <input style="outline: none;" id="{{$comboId}}" type="{{$type}}" value="{{$combos[$i][$comboColumn]}}" class="table-input" readonly>
                                    </div>
                                </td>
                            @else
                                @php
                                    $fabricId = $fabrications[$fabricCol]['id'];
                                    if($j%2==0) $comboId = "combo".$combos[$i]['id']."-fabric".$fabrications[$fabricCol]['id']."-rf";
                                    if($j%2==1) $comboId = "combo".$combos[$i]['id']."-fabric".$fabrications[$fabricCol++]['id']."-rg";
                                    $yarnAllocationsColumnValue = null;
                                    $readonly = 'readonly';
                                    if(isset($yarnAllocations[$allocationId]) && $yarnAllocations[$allocationId]['fabric_id'] == $fabrications[$fabricDx]['id']){
                                        if($j%2==0) $yarnAllocationsColumnValue = $yarnAllocations[$allocationId]['req_finished'];
                                        if($j%2==1) {
                                            $yarnAllocationsColumnValue = $yarnAllocations[$allocationId]['req_gray'];
                                            $allocationId++;
                                        }
                                        $readonly = null;
                                    }
                                    if($j%2==1) $fabricDx++;
                                @endphp
                                <td>
                            <div style="text-align: center; width: {{$width}}px !important;">
                                <input style="outline: none;" id="{{$comboId}}" type="number" value="{{$yarnAllocationsColumnValue}}" class="table-input" readonly>
                            </div>
                            </td>
                            @endif
                            @endfor
                        </tr>
                        @endfor
                        <tr>
                            @php
                                $fabricCol = 0;
                                $tf = 0;
                                $tg = 0;
                            @endphp
                            @for ($j=0; $j<$col2-7; $j++)
                                @if($j==0)
                                <td colspan="7">Total</td>
                                    @elseif($j<$col2-10)
                                    @php
                                    if($j%2==1){
                                        $id=$fabrications[$fabricCol]['id']."-tf";
                                        $vlo=$fabrications[$fabricCol]['total_finished'];
                                        $tf +=$vlo;
                                        }
                                        if($j%2==0){
                                            $id=$fabrications[$fabricCol]['id']."-tg";
                                            $vlo=$fabrications[$fabricCol++]['total_gray'];
                                            $tg +=$vlo;
                                        }
                                        @endphp
                                        <td>
                                <div style="text-align: center; width: {{$width}}px !important;">
                                    <input style="outline: none;" id="{{$id}}" type="number" value="{{$vlo}}" class="table-input" readonly>
                                </div>
                                </td> @elseif($j<$col2-8) @php if($j%2==1){$id='tf' ; $vlo=$tf;} if($j%2==0){$id='tg' ; $vlo=$tg;} @endphp <td>
                                    <div style="text-align: center; width: {{$width}}px !important;">
                                        <input style="outline: none;" id="{{$id}}" type="number" value="{{$vlo}}" class="table-input" readonly>
                                    </div>
                                </td>
                                @else
                                    <td></td>
                                @endif
                            @endfor
                        </tr>
                        <tr></tr>
                    </tbody>
                    </table>


                    <div>
                        <p class="d-inline" style="font-size: 10px; padding: 0px; margin-top: 5px;"> Booking Based On Knitting & Dyeing Process Loss <span style="font-size: 12px; font-weight: bold;">
                            {{ $yarnBooking->process_loss??"" }}% </span> Extra Cutting- <span style="font-size: 12px; font-weight: bold;">
                            {{ $yarnBooking->extra_cutting??"" }}% </span>
                        </p>
                        <div class="row">
                            <div class="col-4" style="font-size:12px;">
                                <p style="font-size: 12px; color: black; margin-top: 10px;">
                                <span>1. Please strictly maintain the above mentioned DIA & GSM</span>
                                <br>
                                <span>2. Color Fastness, rubbing and chemical test should be Pass.</span>
                                <br>
                                <span>3. SHRINKAGE & GSM ALLOW BELLOW ±5% (After wash)***</span>
                                </p>
                            </div>
                            <div class="col-4" style="font-size:12px;">
                                <div id="remarkList">
                                    <table style="width: 100%; ">
                                        @foreach ($remarks as $remark)
                                            <tr>
                                                <td>
                                                    <input class="form-control" style="height: 25px;padding: 2px; border-radius: 0px !important; font-size: 10px; outline: none !important; " type="text" value="{{ $remark }}" id="{{  $loop->index }}remarks" readonly>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="col-4 d-flex" style="font-size:12px; justify-content: end;">
                                <table >
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
                                                        <textarea onmouseup="changeSummeryTextAreaHight({{$i}}, 'item')" name="summery{{$i}}"  id="summery{{$i}}-item" type="text"  class="table-input summeryInput" style="outline: none;height: 19px !important;" readonly>{{ $summeries[$i][0] }}</textarea>
                                                </div>
                                            </td>
                                            <td style="border: 1px solid #000; ">
                                                <div style="text-align: center;">
                                                    <textarea onmouseup="changeSummeryTextAreaHight({{$i}}, 'fabric')" name="summery{{$i}}" id="summery{{$i}}-fabric" class="textArea summeryInput" name="" style="outline: none; height: 19px; width: 100%;border: 0; text-align: center;" readonly>{{ $summeries[$i][1] }}</textarea>
                                                </div>
                                            </td>
                                            <td style="border: 1px solid #000; ">
                                                <div style="text-align: center; ">
                                                    <textarea onmouseup="changeSummeryTextAreaHight({{$i}}, 'qty')" name="summery{{$i}}" id="summery{{$i}}-qty" type="text"  class="table-input summeryInput" style="outline: none;height: 19px !important;" readonly>{{ $summeries[$i][2] }}</textarea>
                                                </div>
                                            </td>
                                        </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row"  style="font-size:11px;color:black; margin-top: 30px;  margin-bottom: 20px;">
                            <div class="col"><u>Asst.Marchandiser</u></div>
                            <div class="col"><u>Marchandiser</u></div>
                            <div class="col"><u>Store(inc)</u></div>
                            <div class="col"><u>Manager(Knitting)</u></div>
                            <div class="col"><u>Senior DGM(MM)</u></div>
                            <div class="col"><u>Executive Director</u></div>
                            <div class="col"><u>Director</u></div>
                          </div>
                    </div>


                </div>
            </div>
            </div>
        </div>

   </div>


@endsection

@section('js')
    <script>

        var maxHight = 0;
        textAreaHightResize();


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


        function changeTextAreaHight(j, row){
            var ele = document.getElementById('fabric' + j + '-' + row);
            var height = getComputedStyle(ele)['height'];
            collection = document.getElementsByClassName("textArea");
            for (let i = 0; i < collection.length; i++) {
                if (collection[i].name == row) {
                    collection[i].style.height = height;
                }
            }
        }

        function saveAsPdf(){
            var pdf = new jsPDF();
            pdf.addHTML(document.getElementById('myTable'), function() {
                pdf.save('table.pdf');
            });
        }

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

        function textAreaHightResize(){
            let elements = document.getElementsByTagName("textarea");
                let fabricMaxHighets = {};
                for (let i = 0; i < elements.length; i++) {
                    let ele = elements[i];
                    if (ele.id != 'orderNo' && !ele.classList.contains("summeryInput")) {
                        ele.style.height = (ele.scrollHeight) + 'px';

                        if (!fabricMaxHighets[ele.name]) fabricMaxHighets[ele.name] = 0;

                        if (fabricMaxHighets[ele.name] < ele.scrollHeight) {
                            fabricMaxHighets[ele.name] = ele.scrollHeight;
                        }
                    }

                }

                for (let i = 0; i < elements.length; i++) {
                    let ele = elements[i];
                    if (ele.id != 'orderNo' && !ele.classList.contains("summeryInput")) {
                        ele.style.height = fabricMaxHighets[ele.name] + 'px';
                    }
                }

                var ele = document.getElementById('orderNo');
                ele.style.height = (ele.scrollHeight) + 'px';

                let elements1 = document.getElementsByClassName("summeryInput");

                let maxHighets = {};

                for (let i = 0; i < elements1.length; i++) {
                    let ele = elements1[i];
                    if (!maxHighets[ele.name]) {
                        maxHighets[ele.name] = 0;
                    }
                    if (maxHighets[ele.name] < ele.scrollHeight) {
                        maxHighets[ele.name] = ele.scrollHeight;
                    }
                }
                for (let i = 0; i < elements1.length; i++) {
                    let ele = elements1[i];
                    ele.style.height = 'auto';
                    ele.style.height = maxHighets[ele.name] + 'px';
                }
            }

    </script>
@endsection
