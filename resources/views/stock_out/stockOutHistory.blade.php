@php
    $stock_out_history = true;
@endphp
@extends('layouts.app')

 @section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
@endsection
<link type="text/css" rel="stylesheet" href="https://unpkg.com/vue-next-select/dist/index.min.css" />
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">

    <div class="br-section-wrapper mt-5">
        <table class="table" id="datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Style No</th>
                <th scope="col">Receiver Name</th>
                <th scope="col">Line no</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($stockOuts as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->style_no }}</td>
                    <td>{{ $item->receiver_name }}</td>
                    <td>{{ $item->line_no }}</td>
                    <td>
                        <a href="{{ route('stock-out-history-info',Crypt::encrypt($item->id)) }}" class="btn btn-sm btn-primary">Details</a>
                       @if (auth()->user()->role_id == 4 or auth()->user()->role_id == 3)
                       <a  href="{{ route('edit_stock_out_info',Crypt::encrypt($item->id)) }}" class="btn btn-sm btn-primary ml-2">Edit</a>
                       @endif

                    </td>
                </tr>
                @endforeach

            </tbody>
          </table>

    </div>


    </div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $(".select2-for").select2({
            tags: false
        });

        $("#datatable").DataTable();

    });

</script>
<script>
      function call(){
        // alert("Hello");
        let id = $('#'+'style_name').val();
        $('#'+'style_name_id').val(id);
        document.getElementById('style_name_id').dispatchEvent(new Event('change'));
    }
     $(document).ready(function() {
        $(".select2-for").select2({
            tags: false
        });

    });

</script>

@endsection
