<div  v-if="stockOutInfos.length > 0" class="row mt-4">
    <div class="col">
        <div class="bd rounded table-responsive p-3">
            <table class="table table-hover mg-b-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Style No</th>
                        <th>Receiver Name</th>
                        <th>Line No</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stockOut as $item )
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->style_no }}</td>
                        <td>{{  $item->receiver_name }}</td>
                        <td>{{ $item->line_no }}</td>
                        <td>{{ $item->date }}</td>
                        <td>
                            <a   href="{{ route('downLoadStockOutInfo',Crypt::encrypt($item->id))  }}" target="_blank"  class="btn btn-sm btn-primary">Download</a>
                            <a   href="{{ route('print-stockout-info',Crypt::encrypt($item->id)) }}"  target="_blank"  class="btn btn-sm btn-primary ml-2">Print</a>
                       </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
