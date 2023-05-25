<a href="{{ route('stock_in_dashboard') }}"
    class="br-menu-link {{ URL::current() == route('stock_in_dashboard') ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="fa fa-list-alt" aria-hidden="true"></i>
        <span class="menu-item-label">Stock In</span>
    </div>
</a>
<a href="{{ route('mrr_list_view') }}"
    class="br-menu-link {{ isset($mr_list) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="fa fa-list" aria-hidden="true"></i>
        <span class="menu-item-label">MRR List</span>
    </div>
</a>




<a href="{{ route('stockOutCreate') }}" class="br-menu-link  {{ isset($stockOutCreate) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="menu-item-icon ion-briefcase tx-24"></i>
        <span class="menu-item-label">Stock Out</span>

    </div>
</a>

<a href="{{ route('receivers') }}" class="br-menu-link  {{ isset($receivers) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="menu-item-icon icon ion-ios-person-outline tx-24"></i>
        <span class="menu-item-label">Receivers</span>
    </div>
</a>

<a href="{{ route('stock_out_history') }}" class="br-menu-link {{ isset($stock_out_history) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="menu-item-icon icon ion-document-text tx-24"></i>
        <span class="menu-item-label">Stock Out History</span>

    </div>
</a>
