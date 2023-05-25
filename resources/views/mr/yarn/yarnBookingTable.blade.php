@php
    $col = count($fabrications);
    $row = count($combos);
    $col2 = 11 + $col * 2;
    $title = ['Fabrication:', 'Item:', 'Fabrics For:', 'Finished Cos/Dzn:', 'Req Finished GSM:', 'Req Finished DIA:', 'Allocated Yarn Count:', 'Process Loss:'];
    $fabricationColums = ['fabrication', 'item', 'fabric_for', 'cos_dzn', 'gsm', 'dia', 'yarn_count', 'process_loss'];
    $width = 60;
    $margin = 336;
    $divWidth = 60 * $col2 - 60 / 2 + 60 + $col2;
@endphp


<style>
    table {
        font-size: 10px;
    }

    td {
        padding: 0px !important;
        margin: 0px !important;
        border: 1px solid #000;
        text-align: center;
    }

    .table-input {
        border: 0;
        width: 100%;
        text-align: center;
        margin: 0px;
        padding: 0px;
        text-align: center;
    }

    input[type=checkbox] {
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




{{-- 60% CMIA COT 40% Recycled POLISTER FREANCE TREE (3 thread) --}}


<div class="d-flex justify-content-end  align-items-center">
    <div>
        <a href="{{ route('print_booking_sheet', $orderId) }}" class="btn btn-sm btn-warning text-white shadow-none"
            target="_blank"><i class="fa fa-print"></i> Print</a>
    </div>
</div>
<div class="scroll" style="color: black;">
    <div class="">
        <div style="padding-top: 100px !important; Width:{{ $divWidth }}px !important;">
            <div style="margin-left: {{ $margin }}px; display: inline-flex; position: relative;">
                <div
                    style="width: 100%; display: block; text-align: center; font-size: 12px; position: absolute; top:-105px; left: 0;">

                    <span style="display: block; font-size: 14px;">BG COLLECTION ltd.</span><br>
                    <span>Baniarchala, Bhabanipur, Gazipur</span><br>
                    <span>
                        REVISED
                        <span><input type="text" value="{{ $yarnBooking->revised }}" id="revised"
                                onkeyup="changeYarnBookingHearderData({{ $orderId }})"
                                style="width: 30px; background-color: #E9ECEF; outline: none; border: none; border-bottom: 1px solid #363637; "></span>
                        BULK BOOKING
                    </span><br>
                    {{-- <span >NEED LYCRA SERTIFICATE</span><br> --}}
                    <span><input type="text" value="{{ $yarnBooking->hrader_text }}" id="hrader_text"
                            onchange="changeYarnBookingHearderData({{ $orderId }})"
                            style="background-color: #E9ECEF; text-align:center; text-transform:uppercase; outline: none; border: none; border-bottom: 1px solid #363637;"></span>

                </div>
                <div style="display:inline; font-size: 12px; position: absolute; top:-62px; left: -215px;">
                    <div style="display:inline">
                        <table class="">
                            <tr>
                                <td class="px-2">Buyer: </td>
                                <td><input style="border:none; width: 100%;" readonly type="text"
                                        value="{{ $orderInfo->buyer_name }}"></td>
                            </tr>
                            <tr>
                                <td class="px-2">Order No:</td>
                                <td>
                                    <textarea id="orderNo" style="border:none; height: 17px !important;" readonly type="text">{{ $orderInfo->order_no }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2">Order Qty:</td>
                                <td><input style="border:none; width: 100%;" min="0" step="0.1"
                                        onchange="changeYarnBookingData({{ $orderId }})" type="number"
                                        id="order_qty" value="{{ floatFormater($yarnBooking->order_qty ?? '') }}"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div style="display:inline;font-size: 12px; position: absolute; top:-45px; right:-185px;">
                    <div style="display:inline">
                        <table class="">
                            <tr>
                                <td class="px-2">Issue Date: </td>
                                <td><input style="border:none" onchange="changeYarnBookingData({{ $orderId }})"
                                        type="date" value="{{ $yarnBooking->issuing_date ?? '' }}" id="issuing_date">
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2">Shipment Date:</td>
                                <td><input style="border:none" onchange="changeYarnBookingData({{ $orderId }})"
                                        type="date" value="{{ $yarnBooking->shipment_date ?? '' }}"
                                        id="shipment_date"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <button class="btn btn-primary " style="position: absolute; top:0; right:-35px;"
                    onclick="getTable(null,true)">+</button>
                <table>
                    <tbody>
                        <tr>
                            <td style="border: 1px solid #000; text-align: center;">Select fabric =></td>
                            @for ($j = 0; $j < $col; $j++)
                                <td style="border: 1px solid #000; ">
                                    <div style="text-align: center; width: {{ $width * 2 + 1 }}px !important;">
                                        <input onchange="setUnsetFabric({{ $fabrications[$j]['id'] }})"
                                            id="fabric{{ $fabrications[$j]['id'] }}-check" type="checkbox"
                                            class="checkBox table-input">
                                    </div>
                                </td>
                            @endfor
                        </tr>
                        @for ($i = 0; $i < 8; $i++)
                            <tr>
                                <td style="border: 1px solid #000; ">
                                    <div style="text-align: center; width: {{ $width * 3 + 1 }}px !important;">
                                        {{ $title[$i] }}
                                    </div>
                                </td>
                                @for ($j = 0; $j < $col; $j++)
                                    <td style="border: 1px solid #000; ">
                                        <div style="text-align: center; width: {{ $width * 2 + 1 }}px !important;">

                                            @if ($i == 0 || $i == 6 || $i == 2)
                                                <textarea {{--  --}}
                                                    onkeydown="moveMouseFocus(this,event, 'fabric', {{ $fabrications[$j]['id'] }}, '{{ $i }}')"
                                                    {{--  --}} name="{{ $fabricationColums[$i] }}" class="textArea"
                                                    onchange="changefabrication({{ $fabrications[$j]['id'] }} , '{{ $fabricationColums[$i] }}')"
                                                    id="fabric{{ $fabrications[$j]['id'] }}-{{ $fabricationColums[$i] }}"
                                                    style="height: 19px !important; width: 100%;border: 0; text-align: center;"
                                                    onkeyup="resizeRealTime(this, {{ $fabrications[$j]['id'] }}, '{{ $fabricationColums[$i] }}', event)"
                                                    onmouseup="changeTextAreaHight({{ $fabrications[$j]['id'] }}, '{{ $fabricationColums[$i] }}')">{{ $fabrications[$j][$fabricationColums[$i]] }}</textarea>
                                            @else
                                                <input
                                                    onchange="changefabrication({{ $fabrications[$j]['id'] }}, '{{ $fabricationColums[$i] }}' )"
                                                    id="fabric{{ $fabrications[$j]['id'] }}-{{ $fabricationColums[$i] }}"
                                                    type="{{ $fabricationColums[$i] == 'cos_dzn' ? 'number' : ($fabricationColums[$i] == 'gsm' ? 'number' : ($fabricationColums[$i] == 'process_loss' ? 'number' : 'text')) }}"
                                                    value="{{ floatFormater($fabrications[$j][$fabricationColums[$i]]) }}"
                                                    class="table-input"
                                                    onkeydown="moveMouseFocus(this,event, 'fabric', {{ $fabrications[$j]['id'] }}, '{{ $i }}')"
                                                    onkeyup="releaseShiftPress()"
                                                    >
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
                        <td>Select</td>
                        <td>Combo</td>
                        <td>Color</td>
                        <td>LD No</td>
                        <td>Shade</td>
                        <td>O.Qty</td>
                        <td>E.Cut</td>
                        <td>N.Qty</td>
                        @for ($j = 0; $j < $col; $j++)
                            <td>R.Fini</td>
                            <td>R.Gray</td>
                        @endfor
                        <td>T.Fini</td>
                        <td>T.Gray</td>
                        <td>R.mrks</td>
                    </tr>
                    @for ($i = 0; $i < $row; $i++)
                        @php
                            $yarnAllocations = $combos[$i]['yarnAllocations'];
                            $allocationId = 0;
                            $fabricCol = 0;
                            $fabricDx = 0;
                        @endphp
                        <tr style="padding: 0;">
                            @for ($j = 0; $j < $col2; $j++)
                                @if ($j == 0)
                                    <td>
                                        <div style="text-align: center; width: {{ $width / 2 }}px !important;">
                                            <input value="{{ $combos[$i]['id'] }}"
                                                onchange="getSelectedFabricItem({{ $combos[$i]['id'] }}, 'combo{{ $i }}-check')"
                                                id="combo{{ $i }}-check" type="checkbox"
                                                class="table-input comboChek">
                                        </div>
                                    </td>
                                @elseif($j < 8 || $col2 - 4 < $j)
                                    @php
                                        $readonly = false;
                                        if ($j - 1 == 0) {
                                            $comboId = 'combo' . $combos[$i]['id'] . '-combo';
                                            $comboColumn = 'combo';
                                            $type = 'text';
                                        }
                                        if ($j - 1 == 1) {
                                            $comboId = 'combo' . $combos[$i]['id'] . '-color';
                                            $comboColumn = 'color';
                                            $type = 'text';
                                        }
                                        if ($j - 1 == 2) {
                                            $comboId = 'combo' . $combos[$i]['id'] . '-ld';
                                            $comboColumn = 'ld_no';
                                            $type = 'text';
                                        }
                                        if ($j - 1 == 3) {
                                            $comboId = 'combo' . $combos[$i]['id'] . '-shade';
                                            $comboColumn = 'shade';
                                            $type = 'text';
                                        }
                                        if ($j - 1 == 4) {
                                            $comboId = 'combo' . $combos[$i]['id'] . '-qty';
                                            $comboColumn = 'qty';
                                            $type = 'number';
                                        }
                                        if ($j - 1 == 5) {
                                            $comboId = 'combo' . $combos[$i]['id'] . '-ecut';
                                            $comboColumn = 'extra_cutting';
                                            $type = 'number';
                                        }
                                        if ($j - 1 == 6) {
                                            $comboId = 'combo' . $combos[$i]['id'] . '-nqty';
                                            $comboColumn = 'new_qty';
                                            $type = 'number';
                                        }
                                        if ($j == $col2 - 3) {
                                            $readonly = true;
                                            $comboId = 'combo' . $combos[$i]['id'] . '-tf';
                                            $comboColumn = 'total_finished';
                                            $type = 'number';
                                        }
                                        if ($j == $col2 - 2) {
                                            $readonly = true;
                                            $comboId = 'combo' . $combos[$i]['id'] . '-tg';
                                            $comboColumn = 'total_gray';
                                            $type = 'number';
                                        }
                                        if ($j == $col2 - 1) {
                                            $comboId = 'combo' . $combos[$i]['id'] . '-rmk';
                                            $comboColumn = 'remarks';
                                            $type = 'text';
                                        }
                                    @endphp
                                    <td>
                                        <div
                                            style="text-align: center; width: {{ $j == 2 ? $width * 2 : $width }}px !important;">
                                            <input
                                                onchange="changeCombo({{ $combos[$i]['id'] }}, '{{ $comboColumn }}')"
                                                id="{{ $comboId }}" type="{{ $type }}"
                                                value="{{ floatFormater($combos[$i][$comboColumn]) }}"
                                                class="table-input" {{ $readonly ? 'readonly' : '' }}
                                                onkeydown="moveMouseFocus(this, event, 'combo', {{ $combos }}, '{{ $i }}')"
                                                onkeyup="releaseShiftPress()"
                                            >
                                        </div>
                                    </td>
                                @else
                                    @php
                                        $fabricId = $fabrications[$fabricCol]['id'];
                                        if ($j % 2 == 0) {
                                            $comboId = 'combo' . $combos[$i]['id'] . '-fabric' . $fabrications[$fabricCol]['id'] . '-rf';
                                        }
                                        if ($j % 2 == 1) {
                                            $comboId = 'combo' . $combos[$i]['id'] . '-fabric' . $fabrications[$fabricCol++]['id'] . '-rg';
                                        }
                                        $yarnAllocationsColumnValue = null;
                                        $readonly = 'readonly';

                                        if (isset($yarnAllocations[$allocationId]) && $yarnAllocations[$allocationId]['fabric_id'] == $fabrications[$fabricDx]['id']) {
                                            if ($j % 2 == 0) {
                                                $yarnAllocationsColumnValue = $yarnAllocations[$allocationId]['req_finished'];
                                            }
                                            if ($j % 2 == 1) {
                                                $yarnAllocationsColumnValue = $yarnAllocations[$allocationId]['req_gray'];
                                                $allocationId++;
                                            }
                                            $readonly = null;
                                        }
                                        if ($j % 2 == 1) {
                                            $fabricDx++;
                                        }
                                    @endphp
                                    <td>
                                        <div style="text-align: center; width: {{ $width }}px !important;">
                                            <input
                                                onchange="changeCombo({{ $combos[$i]['id'] }}, '{{ $j % 2 == 0 ? 'rf' : 'rg' }}', {{ $fabricId }})"
                                                id="{{ $comboId }}" type="number"
                                                value="{{ floatFormater($yarnAllocationsColumnValue) }}"
                                                class="table-input" {{ $readonly ?? '' }}
                                                onkeydown="moveMouseFocus(this, event, 'combo', {{ $combos }}, '{{ $i }}')"
                                                onkeyup="releaseShiftPress()"
                                            >
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
                        @for ($j = 0; $j < $col2 - 7; $j++)
                            @if ($j == 0)
                                <td colspan="8">Total</td>
                            @elseif($j < $col2 - 10)
                                @php

                                    if ($j % 2 == 1) {
                                        $id = $fabrications[$fabricCol]['id'] . '-tf';
                                        $vlo = $fabrications[$fabricCol]['total_finished'];
                                        $tf += $vlo;
                                    }
                                    if ($j % 2 == 0) {
                                        $id = $fabrications[$fabricCol]['id'] . '-tg';
                                        $vlo = $fabrications[$fabricCol++]['total_gray'];
                                        $tg += $vlo;
                                    }
                                @endphp
                                <td>
                                    <div style="text-align: center; width: {{ $width }}px !important;">
                                        <input id="{{ $id }}" type="number"
                                            value="{{ floatFormater($vlo) }}" class="table-input" readonly>
                                    </div>
                                </td>
                            @elseif($j < $col2 - 8)
                                @php
                                    if ($j % 2 == 1) {
                                        $id = 'tf';
                                        $vlo = $tf;
                                    }
                                    if ($j % 2 == 0) {
                                        $id = 'tg';
                                        $vlo = $tg;
                                    }
                                @endphp
                                <td>
                                    <div style="text-align: center; width: {{ $width }}px !important;">
                                        <input id="{{ $id }}" type="number"
                                            value="{{ floatFormater($vlo) }}" class="table-input" readonly>
                                    </div>
                                </td>
                            @else
                                <td></td>
                            @endif
                        @endfor
                    </tr>
                </tbody>
            </table>


            <div>
                <div class="d-inline">
                    <button class="btn btn-primary" onclick="getTable(true,null)">+</button>
                </div>

                <p class="d-inline" style="font-size: 10px; padding: 0px; color: black; margin-top: 5px;">Booking
                    Based On Knitting & Dyeing Process Loss
                    <span>
                        <input onchange="changeYarnBookingData({{ $orderId }}, 'processLose')" type="number"
                            min="0" value="{{ floatFormater($yarnBooking->process_loss ?? '') }}"
                            id="process_loss"
                            style="width: 30px; margin-left: 5px;font-size: 12px; font-weight: bold; text-align: center;">
                        %
                    </span>
                    Extra Cutting-
                    <span>
                        <input onchange="changeYarnBookingData({{ $orderId }}, 'processLose')" type="number"
                            min="0" value="{{ floatFormater($yarnBooking->extra_cutting ?? '') }}"
                            id="extra_cutting"
                            style="width: 30px; margin-left: 5px;font-size: 12px; font-weight: bold; text-align: center;">
                        %
                    </span>
                </p>

            </div>


            <div class="row">
                <div class="col-4" style="font-size:12px;">
                    <div style="font-size: 12px; color: black; margin-top: 10px; white-space: normal;">

                        <span>1. Please strictly maintain the above mentioned DIA & GSM</span><br>
                        <span>2. Color Fastness, rubbing and chemical test should be Pass.</span><br>
                        <span>3. SHRINKAGE & GSM ALLOW BELLOW ±5% (After wash)***</span>

                    </div>
                </div>
                <div id="remarkList" class="col-4" style="font-size:12px;">


                </div>

                <div class="col-4 d-flex" style="font-size:12px; justify-content: end;">
                    <div id="summery" style="display:inline;">

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
