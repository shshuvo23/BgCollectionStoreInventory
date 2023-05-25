<div class="dropdown show">
    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Action
    </a>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <a href="{{ route('boking_histories', Crypt::encrypt($order->id)) }}" class="dropdown-item">Booking History</a>
        <a href="{{ route('stock_histories', Crypt::encrypt($order->id) ) }}" class="dropdown-item">Stock History</a>
        <a href="{{ route('stock_kout_histories', Crypt::encrypt($order->id)) }}" class="dropdown-item">Stock out History</a>
    </div>
</div>
