<table  class="" style="font-size: 12px; margin-left: {{((100/$col2)*3)+1}}%; margin-right: {{(100/$col2)*3}}%; margin-bottom: 5px;">

    <tbody>
        <tr>
            <td></td>
            @for($j=0; $j<$col; $j++)
            <td><input onchange="setUnsetFabric({{$fabrications[$j]['id']}})" style="width: 20%;" id="fabric{{$fabrications[$j]['id']}}-check" type="checkbox" class="checkBox table-input"></td>
            @endfor
        </tr>
        @for($i=0; $i<7; $i++)
            <tr>
                <td class="header-td">
                    <input type="text" value="{{ $title[$i] }}" style="border: 0; height:100%; width: 100%; text-align: center; margin: 0px; padding: 0px; outline:none;" readonly >
                </td>

                @for ($j=0; $j<$col; $j++)
                    <td class="header-td">
                        @if($i==0)
                            <textarea onchange="changefabrication({{$fabrications[$j]['id']}},{{$j}})" id="fabric{{$j}}-{{$fabricationColums[$i]}}" name="" style="height: 100%; width: 100%;border: 0; text-align: center;" onmouseup="changeTextAreaHight({{$j}})">{{ $fabrications[$j][$fabricationColums[$i]] }}</textarea>
                        @elseif($i==2)
                            <select onchange="changefabrication({{$fabrications[$j]['id']}},{{$j}}, '{{ $fabricationColums[$i]=='cos_dzn'? true:false }}' )" id="fabric{{$j}}-{{$fabricationColums[$i]}}" class="select2" style="width: 100%;" value="{{ $fabrications[$j][$fabricationColums[$i]] }}">
                                <option value="">--Fabric For--</option>
                                @foreach ($febricParts as $febricPart)
                                    <option value="{{$febricPart->id}}" {{$fabrications[$j]['fabric_for']==$febricPart->id?'selected':''}}>{{$febricPart->name}}</option>
                                @endforeach
                            </select>
                        @else
                            <input onchange="changefabrication({{$fabrications[$j]['id']}},{{$j}}, '{{ $fabricationColums[$i]=='cos_dzn'? true:false }}' )" id="fabric{{$j}}-{{$fabricationColums[$i]}}" type="{{ $fabricationColums[$i]=='cos_dzn'? 'number':($fabricationColums[$i]=='gsm'? 'number':'text') }}" value="{{ $fabrications[$j][$fabricationColums[$i]] }}" class="table-input">
                        @endif
                    </td>
                @endfor
            </tr>
        @endfor
        <tr>

        </tr>
    </tbody>
</table>



 <table class="table " style="font-size: 12px; margin: 0; width: 100%;">
    <tbody>
        <tr >
            <td class=""></td>
            <td class="header-td">Combo</td>
            <td class="header-td">Color</td>
            <td class="header-td">LD No</td>
            <td class="header-td">Shade</td>
            <td class="header-td">O.Qty</td>
            @for ($j=0; $j<$col; $j++)
                <td class="header-td">R.Fini</td>
                <td class="header-td">R.Gray</td>
            @endfor
            <td class="header-td">T.Fini</td>
            <td class="header-td">T.Gray</td>
            <td class="header-td">R.mrks</td>
        </tr>
        @for ($i=0; $i<$row; $i++)
            @php

                $yarnAllocations = $combos[$i]['yarnAllocations'];
                // print_r($yarnAllocations);
                $allocationId = 0;
                $fabricCol = 0;
                $fabricDx = 0;
            @endphp
            <tr >
                <td class="" ><input value="{{$combos[$i]['id']}}" onchange="getSelectedFabricItem({{$combos[$i]['id']}})" id="combo{{$i}}-radio" type="radio" class="table-input" name="combo"></td>
                @for ($j=0; $j<$col2; $j++)

                        @if($j<5 || $col2-4<$j)
                            @php
                                if($j==0) {$comboId = "combo".$combos[$i]['id']."-combo"; $comboColumn = "combo"; $type = 'text';}
                                if($j==1) {$comboId = "combo".$combos[$i]['id']."-color"; $comboColumn = "color";$type = 'text';}
                                if($j==2) {$comboId = "combo".$combos[$i]['id']."-ld"; $comboColumn = "ld_no";$type = 'text';}
                                if($j==3) {$comboId = "combo".$combos[$i]['id']."-shade"; $comboColumn = "shade";$type = 'text';}
                                if($j==4) {$comboId = "combo".$combos[$i]['id']."-qty"; $comboColumn = "qty";$type = 'number';}
                                if($j==$col2-3) {$comboId = "combo".$combos[$i]['id']."-tf"; $comboColumn = "total_finished";$type = 'number';}
                                if($j==$col2-2) {$comboId = "combo".$combos[$i]['id']."-fg"; $comboColumn = "total_gray";$type = 'number';}
                                if($j==$col2-1) {$comboId = "combo".$combos[$i]['id']."-rmk"; $comboColumn = "remarks";$type = 'text';}
                            @endphp
                            <td class="header-td">
                                <input onchange="changeCombo({{$combos[$i]['id']}}, '{{$comboColumn}}')" id="{{$comboId}}" type="{{$type}}" value="{{$combos[$i][$comboColumn]}}" class="table-input">
                            </td>
                        @else
                            @php
                                if($j%2==1) $comboId = "combo".$combos[$i]['id']."-fabric".$fabrications[$fabricCol]['id']."-rf";
                                if($j%2==0) $comboId = "combo".$combos[$i]['id']."-fabric".$fabrications[$fabricCol++]['id']."-fg";
                                $yarnAllocationsColumnValue = null;
                                $readonly = 'readonly';

                                if(isset($yarnAllocations[$allocationId]) && $yarnAllocations[$allocationId]['fabric_id'] == $fabrications[$fabricDx]['id']){

                                    if($j%2==1) $yarnAllocationsColumnValue = $yarnAllocations[$allocationId]['req_finished'];
                                    if($j%2==0) {$yarnAllocationsColumnValue = $yarnAllocations[$allocationId]['req_gray'];$allocationId++;}
                                    $readonly = null;
                                }
                                if($j%2==0) $fabricDx++;
                            @endphp
                            <td class="header-td">
                                <input onchange="changeCombo({{$combos[$i]['id']}}, 'rfg')" id="{{$comboId}}" type="number" value="{{$yarnAllocationsColumnValue}}" class="table-input" {{$readonly??''}}>
                            </td>
                        @endif
                @endfor
            </tr>
        @endfor
    </tbody>
</table>
