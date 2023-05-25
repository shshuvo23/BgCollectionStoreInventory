<a href="{{ url('/') }}" class="br-menu-link {{ isset($dashboard) ? 'active' : '' }} ">
    <div class="br-menu-item">
        <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
        <span class="menu-item-label">Booking</span>
    </div>
</a>

<a href="{{ route('order_list_for_booking') }}" class="br-menu-link {{ isset($yarn_booking) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="menu-item-icon icon ion-document-text tx-24"></i>
        <span class="menu-item-label">Yarn Booking</span>

    </div>
</a>

