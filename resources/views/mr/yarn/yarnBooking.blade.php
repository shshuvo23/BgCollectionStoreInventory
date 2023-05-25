{{-- <!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Excel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  </head>
  <body> --}}

@php
    $yarn_booking = true;
@endphp
@extends('layouts.app')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <style>
        .select2-results__options {
            font-size: 8px !important;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 0px solid #aaa;
            border-radius: 0px !important;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            /* display: inline!important; */
            /* padding-left: 0px!important;
                                          padding-right: 0px!important; */
            /* overflow: ''!important; */
            /* text-overflow: ''!important; */
            white-space: normal !important;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 0px solid #aaa;
            border-radius: 0px !important;
            height: 30px !important;
        }
    </style>
@endsection

@section('content')
    <div class="px-3">
        <div id="table">

        </div>
    </div>
    <div style="display: flex; justify-content: center">
        <button onclick="sendBooking({{ $orderId }})" class="btn btn-success px-5 mt-5">Send Booking</button>
    </div>
    {{-- <input onkeydown="moveMouseFocus()" onkeyup="alert()" type="text"> --}}
    {{--  --}}
@endsection


@section('js')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let highlighter = "#adeaa2";
        let shiftIsPressed = false;
        getTable();

        function getTable(row = null, col = null) {
            $.get('{{ route('get_yarn_booking_table') }}', {
                row: row,
                col: col,
                id: '{{ $orderId }}'
            }, function(data) {
                document.getElementById('table').innerHTML = data;
                $(".select2").select2({
                    tags: false
                });
                remarksList(false);
                getSummery(false);
                textAreaHightResize();

            });
        }
    </script>

    <script>
        function changeTextAreaHight(j, row) {
            var ele = document.getElementById('fabric' + j + '-' + row);
            var height = getComputedStyle(ele)['height'];
            collection = document.getElementsByClassName("textArea");
            for (let i = 0; i < collection.length; i++) {
                if (collection[i].name == row) {
                    collection[i].style.height = height;
                }
            }
        }

        function resizeRealTime(ele, id, row, event = null) {
            if (event.key == "Shift") {
                releaseShiftPress();
            }
            ele.style.height = 0 + "px";
            ele.style.height = (ele.scrollHeight) + 'px';
            changeTextAreaHight(id, row);
        }

        function textAreaHightResize() {
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
    <script>
        function changefabrication(id, changedColumn) {
            $("input").css("background-color", "#fff");
            fabric = $('#fabric' + id + '-fabrication').val();
            item = $('#fabric' + id + '-item').val();
            fabricFor = $('#fabric' + id + '-fabric_for').val();
            dzn = parseFloat($('#fabric' + id + '-cos_dzn').val());
            if (!dzn) {
                $('#fabric' + id + '-cos_dzn').val(0);
                dzn = 0;
            }
            pcsLoss = parseFloat($('#fabric' + id + '-process_loss').val());
            if (!pcsLoss) {
                $('#fabric' + id + '-process_loss').val(0);
                pcsLoss = 0;
            }
            gsm = $('#fabric' + id + '-gsm').val();
            dia = $('#fabric' + id + '-dia').val();
            count = $('#fabric' + id + '-yarn_count').val();

            $.get('{{ route('change_fabrication') }}', {
                id: id,
                fabric: fabric,
                item: item,
                fabricFor: fabricFor,
                dzn: dzn,
                gsm: gsm,
                dia: dia,
                count: count,
                pcsLoss: pcsLoss
            }, function(data) {

                for (let i = 0; i < data.length; i++) {
                    let comboId = data[i];
                    let nqty = parseFloat($("#combo" + comboId + "-nqty").val());

                    let rf = Math.ceil((nqty / 12) * dzn);
                    let rg = Math.ceil(rf / ((100 - pcsLoss) / 100));

                    let orf = parseFloat($("#combo" + comboId + "-fabric" + id + "-rf").val());
                    let org = parseFloat($("#combo" + comboId + "-fabric" + id + "-rg").val());

                    let ctf = parseFloat($("#combo" + comboId + "-tf").val());
                    let ctg = parseFloat($("#combo" + comboId + "-tg").val());
                    let ftf = parseFloat($("#" + id + "-tf").val());
                    let ftg = parseFloat($("#" + id + "-tg").val());
                    let TF = parseFloat($("#tf").val());
                    let TG = parseFloat($("#tg").val());

                    $("#combo" + comboId + "-tf").val(ctf - orf + rf);
                    $("#combo" + comboId + "-tg").val(ctg - org + rg);
                    $("#" + id + "-tf").val(ftf - orf + rf);
                    $("#" + id + "-tg").val(ftg - org + rg);
                    $("#tf").val(TF - orf + rf);
                    $("#tg").val(TG - org + rg);
                    $("#combo" + comboId + "-fabric" + id + "-rf").val(rf);
                    $("#combo" + comboId + "-fabric" + id + "-rg").val(rg);

                    if (changedColumn == 'process_loss') {
                        $("#combo" + comboId + "-tg").css("background-color", highlighter);
                        $("#" + id + "-tg").css("background-color", highlighter);
                        $("#tg").css("background-color", highlighter);
                        $("#combo" + comboId + "-fabric" + id + "-rg").css("background-color", highlighter);
                    } else {
                        $("#combo" + comboId + "-tf").css("background-color", highlighter);
                        $("#combo" + comboId + "-tg").css("background-color", highlighter);
                        $("#" + id + "-tf").css("background-color", highlighter);
                        $("#" + id + "-tg").css("background-color", highlighter);
                        $("#tf").css("background-color", highlighter);
                        $("#tg").css("background-color", highlighter);
                        $("#combo" + comboId + "-fabric" + id + "-rf").css("background-color", highlighter);
                        $("#combo" + comboId + "-fabric" + id + "-rg").css("background-color", highlighter);
                    }
                }
            });
        }

        function getSelectedFabricItem(id, eleId) {
            let checkBooxes = document.getElementsByClassName("checkBox");
            let comboChek = document.getElementsByClassName("comboChek");
            for (var dx = 0; dx < checkBooxes.length; dx++) {
                checkBooxes[dx].checked = "";
            }
            for (var dx = 0; dx < comboChek.length; dx++) {
                if (comboChek[dx].id != eleId) {
                    comboChek[dx].checked = "";
                } else {
                    if (!comboChek[dx].checked) {
                        return;
                    }
                }
            }

            $.get('{{ route('get_selected_fabric_item') }}', {
                id: id
            }, function(res) {
                let data = res[1];
                for (i = 0; i < data.length; i++) {
                    document.getElementById('fabric' + data[i] + '-check').checked = "checked";
                }
            });
        }

        function setUnsetFabric(id) {
            $("input").css("background-color", "#fff");
            let combos = document.getElementsByClassName("comboChek");
            let combo = null;
            for (let i = 0; i < combos.length; i++) {
                if (combos[i].checked) {
                    combo = combos[i].value;
                }
            }
            if (combo != null) {
                let status = false;
                if (document.getElementById('fabric' + id + '-check').checked) {
                    status = true;
                }

                $.get('{{ route('set_unset_fabric') }}', {
                    comboId: combo,
                    fabricId: id,
                    status: status
                }, function(data) {

                });

                if (status) {

                    let nqty = parseFloat($("#combo" + combo + "-nqty").val());
                    let dzn = parseFloat($("#fabric" + id + "-cos_dzn").val());
                    let pcsls = parseFloat($("#fabric" + id + "-process_loss").val());
                    let rf = Math.ceil((nqty / 12) * dzn);
                    let rg = Math.ceil(rf / ((100 - pcsls) / 100));

                    let tf = parseFloat($("#combo" + combo + "-tf").val());
                    let tg = parseFloat($("#combo" + combo + "-tg").val());
                    tf += rf;
                    tg += rg;

                    $("#combo" + combo + "-tf").val(tf);
                    $("#combo" + combo + "-tg").val(tg);

                    $("#combo" + combo + "-fabric" + id + "-rf").val(rf);
                    $("#combo" + combo + "-fabric" + id + "-rf").removeAttr('readonly');
                    $("#combo" + combo + "-fabric" + id + "-rg").val(rg);
                    $("#combo" + combo + "-fabric" + id + "-rg").removeAttr('readonly');

                    tf = parseFloat($("#" + id + "-tf").val());
                    tg = parseFloat($("#" + id + "-tg").val());
                    tf += rf;
                    tg += rg;
                    $("#" + id + "-tf").val(tf);
                    $("#" + id + "-tg").val(tg);

                    tf = parseFloat($("#tf").val());
                    tg = parseFloat($("#tg").val());
                    tf += rf;
                    tg += rg;
                    $("#tf").val(tf);
                    $("#tg").val(tg);

                    $("#combo" + combo + "-tf").css("background-color", highlighter);
                    $("#combo" + combo + "-tg").css("background-color", highlighter);
                    $("#combo" + combo + "-fabric" + id + "-rf").css("background-color", highlighter);
                    $("#combo" + combo + "-fabric" + id + "-rg").css("background-color", highlighter);
                    $("#" + id + "-tf").css("background-color", highlighter);
                    $("#" + id + "-tg").css("background-color", highlighter);
                    $("#tf").css("background-color", highlighter);
                    $("#tg").css("background-color", highlighter);

                } else {
                    let rf = parseFloat($("#combo" + combo + "-fabric" + id + "-rf").val());
                    let rg = parseFloat($("#combo" + combo + "-fabric" + id + "-rg").val());

                    let tf = parseFloat($("#combo" + combo + "-tf").val());
                    let tg = parseFloat($("#combo" + combo + "-tg").val());
                    tf -= rf;
                    tg -= rg;

                    $("#combo" + combo + "-tf").val(tf);
                    $("#combo" + combo + "-tg").val(tg);
                    $("#combo" + combo + "-fabric" + id + "-rf").val('');
                    $("#combo" + combo + "-fabric" + id + "-rf").attr('readonly', 'readonly');
                    $("#combo" + combo + "-fabric" + id + "-rg").val('');
                    $("#combo" + combo + "-fabric" + id + "-rg").attr('readonly', 'readonly');


                    tf = parseFloat($("#" + id + "-tf").val());
                    tg = parseFloat($("#" + id + "-tg").val());
                    tf -= rf;
                    tg -= rg;
                    $("#" + id + "-tf").val(tf);
                    $("#" + id + "-tg").val(tg);

                    tf = parseFloat($("#tf").val());
                    tg = parseFloat($("#tg").val());
                    tf -= rf;
                    tg -= rg;
                    $("#tf").val(tf);
                    $("#tg").val(tg);

                    $("#combo" + combo + "-tf").css("background-color", highlighter);
                    $("#combo" + combo + "-tg").css("background-color", highlighter);
                    $("#combo" + combo + "-fabric" + id + "-rf").css("background-color", highlighter);
                    $("#combo" + combo + "-fabric" + id + "-rg").css("background-color", highlighter);
                    $("#" + id + "-tf").css("background-color", highlighter);
                    $("#" + id + "-tg").css("background-color", highlighter);
                    $("#tf").css("background-color", highlighter);
                    $("#tg").css("background-color", highlighter);
                }

            } else {
                document.getElementById('fabric' + id + '-check').checked = "";
                alert('Please select any Combo');
            }

        }

        function changeCombo(comboId, changedColumn, fabricId = null) {

            $("input").css("background-color", "#fff");
            let qty = parseFloat($('#combo' + comboId + '-qty').val());
            let ecut = parseFloat($('#combo' + comboId + '-ecut').val());
            let nqty = parseFloat($('#combo' + comboId + '-nqty').val());

            if (!qty) qty = 0;
            if (!ecut) ecut = 0;
            if (!nqty) nqty = 0;

            if (changedColumn == 'qty' || changedColumn == 'extra_cutting') {
                nqty = Math.ceil(qty + (qty * (ecut / 100)));
                $('#combo' + comboId + '-nqty').val(nqty);
                $('#combo' + comboId + '-nqty').css("background-color", highlighter);

            }
            let comboRow = [];
            $.get('{{ route('get_selected_fabric_item') }}', {
                id: comboId
            }, function(res) {
                let value = res[0];
                let data = res[1];
                if (changedColumn == 'qty' || changedColumn == 'extra_cutting' || changedColumn == 'new_qty' ||
                    changedColumn == 'rf' || changedColumn == 'rg') {
                    for (let i = 0; i < data.length; i++) {
                        let rf, rg, orf, org;
                        if (changedColumn == 'qty' || changedColumn == 'extra_cutting' || changedColumn ==
                            'new_qty') {
                            let dzn = parseFloat($("#fabric" + data[i] + "-cos_dzn").val());
                            let pcslos = parseFloat($("#fabric" + data[i] + "-process_loss").val());
                            if (!dzn) {
                                dzn = 0;
                            }
                            if (!pcslos) {
                                pcslos = 0;
                            }

                            rf = Math.ceil((nqty / 12) * dzn);
                            rg = Math.ceil(rf / ((100 - pcslos) / 100));

                            orf = parseFloat($("#combo" + comboId + "-fabric" + data[i] + "-rf").val());
                            if (!orf) {
                                $("#combo" + comboId + "-fabric" + data[i] + "-rf").val(0);
                                orf = 0;
                            }

                            org = parseFloat($("#combo" + comboId + "-fabric" + data[i] + "-rg").val());
                            if (!org) {
                                $("#combo" + comboId + "-fabric" + data[i] + "-rg").val(0);
                                org = 0;
                            }

                        } else {

                            let pcslos = $("#fabric" + fabricId + "-process_loss").val();


                            rf = parseFloat($("#combo" + comboId + "-fabric" + data[i] + "-rf").val());
                            if (!rf) {
                                $("#combo" + comboId + "-fabric" + data[i] + "-rf").val();
                                rf = 0;
                            }

                            rg = parseFloat($("#combo" + comboId + "-fabric" + data[i] + "-rg").val());
                            if (!rg) {
                                $("#combo" + comboId + "-fabric" + data[i] + "-rg").val();
                                rg = 0;
                            }

                            if (changedColumn == 'rf') rg = Math.ceil(rf / ((100 - pcslos) / 100));

                            orf = value[i].req_finished;
                            org = value[i].req_gray;
                        }

                        $("#combo" + comboId + "-fabric" + data[i] + "-rf").val(rf);
                        $("#combo" + comboId + "-fabric" + data[i] + "-rg").val(rg);

                        let tf = parseFloat($("#combo" + comboId + "-tf").val());
                        let tg = parseFloat($("#combo" + comboId + "-tg").val());

                        $("#combo" + comboId + "-tf").val(tf - orf + rf);
                        $("#combo" + comboId + "-tg").val(tg - org + rg);

                        tf = parseFloat($("#" + data[i] + "-tf").val());
                        tg = parseFloat($("#" + data[i] + "-tg").val());

                        $("#" + data[i] + "-tf").val(tf - orf + rf);
                        $("#" + data[i] + "-tg").val(tg - org + rg);

                        tf = parseFloat($("#tf").val());
                        tg = parseFloat($("#tg").val());

                        $("#tf").val(tf - orf + rf);
                        $("#tg").val(tg - org + rg);

                        if (changedColumn == 'rf' || changedColumn == 'rg') {
                            if (changedColumn == 'rf') {
                                $("#combo" + comboId + "-tf").css("background-color", highlighter);
                                $("#combo" + comboId + "-tg").css("background-color", highlighter);
                                $("#combo" + comboId + "-fabric" + fabricId + "-rg").css("background-color",
                                    highlighter);
                            }
                            if (changedColumn == 'rg') $("#combo" + comboId + "-tg").css("background-color",
                                highlighter);
                            if (changedColumn == 'rf' && fabricId == data[i]) {
                                $("#" + data[i] + "-tf").css("background-color", highlighter);
                                $("#" + data[i] + "-tg").css("background-color", highlighter);
                            }
                            if (changedColumn == 'rg' && fabricId == data[i]) $("#" + data[i] + "-tg").css(
                                "background-color", highlighter);
                            if (changedColumn == 'rf') {
                                $("#tf").css("background-color", highlighter);
                                $("#tg").css("background-color", highlighter);
                            }
                            if (changedColumn == 'rg') $("#tg").css("background-color", highlighter);
                        } else {
                            $("#combo" + comboId + "-fabric" + data[i] + "-rf").css("background-color",
                                highlighter);
                            $("#combo" + comboId + "-fabric" + data[i] + "-rg").css("background-color",
                                highlighter);
                            $("#combo" + comboId + "-tf").css("background-color", highlighter);
                            $("#combo" + comboId + "-tg").css("background-color", highlighter);
                            $("#" + data[i] + "-tf").css("background-color", highlighter);
                            $("#" + data[i] + "-tg").css("background-color", highlighter);
                            $("#tf").css("background-color", highlighter);
                            $("#tg").css("background-color", highlighter);
                        }


                    }
                }

                comboRow[0] = $('#combo' + comboId + '-combo').val();
                comboRow[1] = $('#combo' + comboId + '-color').val();
                comboRow[2] = $('#combo' + comboId + '-ld').val();
                comboRow[3] = $('#combo' + comboId + '-shade').val();


                comboRow[4] = $('#combo' + comboId + '-qty').val();
                if (!comboRow[4]) {
                    $('#combo' + comboId + '-qty').val(0);
                    comboRow[4] = 0;
                }
                comboRow[5] = $('#combo' + comboId + '-ecut').val();
                if (!comboRow[5]) {
                    $('#combo' + comboId + '-ecut').val(0);
                    comboRow[5] = 0;
                }
                comboRow[6] = $('#combo' + comboId + '-nqty').val();
                if (!comboRow[6]) {
                    $('#combo' + comboId + '-nqty').val(0);
                    comboRow[6] = 0;
                }
                comboRow[7] = $('#combo' + comboId + '-tf').val();
                if (!comboRow[7]) {
                    $('#combo' + comboId + '-tf').val(0);
                    comboRow[7] = 0;
                }
                comboRow[8] = $('#combo' + comboId + '-tg').val();
                if (!comboRow[8]) {
                    $('#combo' + comboId + '-tg').val(0);
                    comboRow[8] = 0;
                }


                comboRow[9] = $('#combo' + comboId + '-rmk').val();
                comboRow[10] = [];
                for (let i = 0; i < data.length; i++) {
                    comboRow[10][i] = [];
                    comboRow[10][i][0] = data[i];
                    comboRow[10][i][1] = $('#combo' + comboId + '-fabric' + data[i] + '-rf').val();
                    if (!comboRow[10][i][1]) {
                        $('#combo' + comboId + '-fabric' + data[i] + '-rf').val(0);
                        comboRow[10][i][1] = 0;
                    }
                    comboRow[10][i][2] = $('#combo' + comboId + '-fabric' + data[i] + '-rg').val();
                    if (!comboRow[10][i][2]) {
                        $('#combo' + comboId + '-fabric' + data[i] + '-fg').val(0);
                        comboRow[10][i][2] = 0;
                    }
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('change_combo') }}',
                    type: 'post',
                    data: {
                        orderId: '{{ $orderId }}',
                        comboId: comboId,
                        changedColumn: changedColumn,
                        comboRow: comboRow
                    },
                    success: function(data) {}
                });

            });
        }
    </script>

    <script>
        function changeYarnBookingData(id, changesField = false) {
            let process_loss = $('#process_loss').val();
            let extra_cutting = $("#extra_cutting").val();
            let issuing_date = $('#issuing_date').val();
            let shipment_date = $('#shipment_date').val();
            let order_qty = $('#order_qty').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: '{{ route('store.yarn') }}',
                data: {
                    process_loss: process_loss,
                    extra_cutting: extra_cutting,
                    issuing_date: issuing_date,
                    shipment_date: shipment_date,
                    order_qty: order_qty,
                    orderId: id,
                    changesField: changesField
                },
                success: function(results) {},
            });
        }

        function changeYarnBookingHearderData(id) {
            let revised = $('#revised').val();
            let hrader_text = $('#hrader_text').val();
            // console.log(id);
            $.ajax({
                type: "get",
                url: '{{ route('insert_header_data') }}',
                data: {
                    revised: revised,
                    hrader_text: hrader_text,
                    OrderId: id
                },
                success: function(results) {},
                // alert("ok");
            });
        }

        function remarksList(remarksInserOrNot) {
            $.ajax({
                type: "get",
                url: '{{ route('remarks') }}',
                data: {
                    remarksInserOrNot: remarksInserOrNot,
                    orderId: '{{ $orderId }}'
                },
                success: function(results) {
                    $('#remarkList').html(results);
                },
            });
        }

        function getSummery(summeryInserOrNot) {
            $.ajax({
                type: "get",
                url: '{{ route('get_summery') }}',
                data: {
                    summeryInserOrNot: summeryInserOrNot,
                    orderId: '{{ $orderId }}'
                },
                success: function(results) {
                    $('#summery').html(results);
                    textAreaHightResize();
                },
            });
        }

        function updateRemarks(id, index) {
            let remark = $('#' + index + 'remarks').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: '{{ route('update.remarks') }}',
                data: {
                    index: index,
                    remarks: remark,
                    orderId: id
                },
                success: function(results) {},
            });
        }

        function updateSummery(id) {
            let item = $("#summery" + id + "-item").val();
            let fabric = $("#summery" + id + "-fabric").val();
            let qty = $("#summery" + id + "-qty").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: '{{ route('update.summery') }}',
                data: {
                    index: id,
                    item: item,
                    fabric: fabric,
                    qty: qty,
                    orderId: '{{ $orderId }}'
                },
                success: function(results) {},
            });
        }

        function moveMouseFocus(ele = null, event = null, table = null, ids = null, columnIndex = null, columns = null) {

            let fabricationColums = ['fabrication', 'item', 'fabric_for', 'cos_dzn', 'gsm', 'dia', 'yarn_count',
                'process_loss'
            ];
            let keys = ['Enter'];

            if (event.key == "Shift") {
                pressShift();
            }

            if (keys.indexOf(event.key) > -1) {
                if (table == "fabric") {
                    if (!shiftIsPressed && fabricationColums.length - 1 > columnIndex) {
                        let ele = document.getElementById("fabric" + ids + "-" + fabricationColums[parseInt(columnIndex) +
                            1]);
                        ele.focus();
                    } else if (shiftIsPressed && columnIndex > 0) {
                        let ele = document.getElementById("fabric" + ids + "-" + fabricationColums[parseInt(columnIndex) -
                            1]);
                        ele.focus();
                    }
                }
                if (table == "combo") {

                    let id = null;
                    if (!shiftIsPressed && ids[parseInt(columnIndex) + 1]) {
                        id = ids[parseInt(columnIndex) + 1].id;
                    }
                    if (shiftIsPressed && ids[parseInt(columnIndex) - 1]) {
                        id = ids[parseInt(columnIndex) - 1].id;
                    }

                    if (id) {
                        let elementId = ele.id;
                        let existId = elementId.split("-")[0].replace("combo", "");
                        let newId = elementId.replace("combo" + existId, "combo" + id);
                        let newEle = document.getElementById(newId);
                        newEle.focus();
                    }
                }
                event.preventDefault();
            }

        }

        function pressShift() {
            if (event.key == "Shift")
                shiftIsPressed = true;
        }

        function releaseShiftPress() {
            if (event.key == "Shift")
                shiftIsPressed = false;
        }

        function sendBooking(id) {
            $.get('{{ route('send_booking') }}', {
                orderId: id
            }, function(data) {
                alert(data);
            })
        }
    </script>
@endsection

{{-- </html>
</body> --}}
