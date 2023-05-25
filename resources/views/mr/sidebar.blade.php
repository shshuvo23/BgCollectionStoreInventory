<a href="{{ url('/') }}" class="br-menu-link {{ isset($dashboard) ? 'active' : '' }} ">
    <div class="br-menu-item">
        <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
        <span class="menu-item-label">Booking</span>
    </div>
</a>
<a href="{{ route('buyer.list') }}" class="br-menu-link {{ isset($buyer_list) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="menu-item-icon ion-android-contacts tx-24"></i>
        <span class="menu-item-label">Buyer list</span>
    </div>
</a>
<a href="{{ route('order.list') }}" class="br-menu-link {{ isset($order_list) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="menu-item-icon ion-social-usd-outline tx-24"></i>
        <span class="menu-item-label">Order list</span>
    </div>
</a>
<a href="{{ route('style.index') }}" class="br-menu-link {{ isset($style_page) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="menu-item-icon  ion-android-bulb tx-24"></i>
        <span class="menu-item-label">Style list</span>
    </div>
</a>
<a href="{{ route('stock_out_history') }}" class="br-menu-link {{ isset($stock_out_history) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="menu-item-icon  icon ion-android-alarm-clock tx-24"></i>
        <span class="menu-item-label">Stock Out History</span>
    </div>
</a>

<a href="{{ route('order.management') }}" class="br-menu-link {{ isset($orderManagement) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="menu-item-icon  icon ion-android-calendar tx-24"></i>
        <span class="menu-item-label">Export Calendar</span>
    </div>
</a>


<a href="{{ route('order_list_for_booking') }}" class="br-menu-link {{ isset($yarn_booking) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="menu-item-icon icon ion-document-text tx-24"></i>
        <span class="menu-item-label">Yarn Booking</span>

    </div>
</a>

