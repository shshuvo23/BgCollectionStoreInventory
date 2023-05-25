<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fabric Part</title>
</head>
<body>
       <div id="yearn_order">
        <table>
            <tbody>
                <tr>
                    <td>
                        <div id="remarkList">

                        </div>
                    </td>
                    <td>
                        <label for="">Process Loss</label>
                        <input onchange="changeYarnBookingData(1)" type="number" min="0" value="{{ $yarnBooking->process_loss??"" }}" id="process_loss">
                    </td>
                    <td>
                        <label for="">Issuing Date</label>
                        <input onchange="changeYarnBookingData(1)" type="date"  value="{{ $yarnBooking->issuing_date??"" }}" id="issuing_date">
                    </td>
                    <td>
                        <label for="">Shipment Date</label>
                        <input onchange="changeYarnBookingData(1)" type="date"  value="{{ $yarnBooking->shipment_date??"" }}" id="shipment_date">
                    </td>
                </tr>
            </tbody>
        </table>
       </div>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script>
        let remarks = [];
        function changeYarnBookingData(id){
           let process_loss = $('#process_loss').val();
           let issuing_date = $('#issuing_date').val();
           let shipment_date = $('#shipment_date').val();
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
                        issuing_date: issuing_date,
                        shipment_date: shipment_date,
                        orderId:id
                    },
                    success: function(results) {

                    },
                });
        }
        remarksList(false);
        function remarksList(remarksInserOrNot) {
            $.ajax({
                    type: "get",
                    url: '{{ route('remarks') }}',
                    data: {
                        remarksInserOrNot:remarksInserOrNot,
                    },
                    success: function(results) {
                         $('#remarkList').html(results);
                    },
                });
        }

        function updateRemarks(id,index){
            let remark = $('#'+index+'remarks').val();
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: '{{ route('update.remarks') }}',
                    data: {
                        index:index,
                        remarks: remark,
                        orderId:id
                    },
                    success: function(results) {
                         console.log(results);
                    },
                });
        }

    </script>

</body>
</html>
