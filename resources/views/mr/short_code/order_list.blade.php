<table class="table table-hover" id="dataTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Order Number</th>
            <th>Total Style</th>
            <th>Created By</th>
            <th>Updated By</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr class="ancor_link" >
                <th onclick="anchorTag( '{{route('style.index',Crypt::encrypt($order->id))}}' )" scope="row">{{ $loop->iteration }}</th>
                <td onclick="anchorTag( '{{route('style.index',Crypt::encrypt($order->id))}}' )">{{ $order->order_no }}</td>
                <td onclick="anchorTag( '{{route('style.index',Crypt::encrypt($order->id))}}' )">{{ DB::table('styles')->where('order_id', $order->id)->count() }}</td>
                <td onclick="anchorTag( '{{route('style.index',Crypt::encrypt($order->id))}}' )" class="text-capitalize"><span
                        class="badge bg-primary">{{ get_user_name($order->created_by) }}</span> </td>
                <td onclick="anchorTag( '{{route('style.index',Crypt::encrypt($order->id))}}' )"class="text-capitalize"><span
                        class="badge bg-{{ $order->updated_by ? 'info' : 'secondary' }}">{{ $order->updated_by ? get_user_name($order->updated_by) : 'not update' }}</span>
                </td>
                <td>
                    <div class="dropdown show">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button"
                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            Action
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a href="{{route('style.index',Crypt::encrypt($order->id))}}" class="dropdown-item"><i class="fa fa-eye"></i> View Styles</a>
                            @if (auth()->user()->role_id != 5 && auth()->user()->role_id != 1 )
                                <a href="{{route('order.edit',Crypt::encrypt($order->id))}}" class="dropdown-item"><i class="fa fa-pencil"></i> Edit</a>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

