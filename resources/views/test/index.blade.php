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
       <div id="febricForm">

       </div>
       <button id="addNewFebric"  onclick="addNewFebricItem(true)">Add New</button>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script>
        addNewFebricItem(false);
        function addNewFebricItem(xyz){
                $.ajax({
                    type: "get",
                    url: '{{ route('new-febric-item') }}',
                    data: {
                        orderId:1,
                        xyz:xyz
                    },
                    success: function(results) {
                        $('#febricForm').html(results);
                    },
                });

        }

        function changeItem(id){
           let name = $('#'+id+'name').val();
           let value = $('#'+id+'value').val();
             $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: '{{ route('store.fabric') }}',
                    data: {
                        name: name,
                        value: value,
                        id:id
                    },
                    success: function(results) {
                          console.log(results);
                          addNewFebricItem(false);
                    },
                });
        }

    </script>

</body>
</html>
