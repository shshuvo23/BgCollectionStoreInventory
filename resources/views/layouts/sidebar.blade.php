<div class="br-logo"><a href="{{ url('/') }}"><span>[</span>BG Collection<span>]</span></a></div>
<div class="br-sideleft overflow-y-auto">
    <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
    <div class="br-sideleft-menu">
        @php
            $auth_role = auth()->user()->role_id;
        @endphp
        @if ($auth_role == 1)
            @include('admin.sidebar')
        @elseif ($auth_role == 2 or $auth_role == 6)
            @include('mr.sidebar')
        @elseif ($auth_role == 3)
            @include('store.sidebar')
        @elseif ($auth_role == 4 or $auth_role == 3)
            @include('stock_out.sidebar')
        @elseif ($auth_role == 7)
            @include('knitting.sidebar')
        @elseif ($auth_role == 8)
            @include('viewerCalender.sidebar')
        @else
            @include('viewers.sidebar')
        @endif
        @if (auth()->user()->role_id != 7 && auth()->user()->role_id != 8)
            <a href="{{ route('inventory.list') }}" class="br-menu-link {{ isset($search_booking) ? 'active' : '' }}">
                <div class="br-menu-item">
                    <i class="menu-item-icon ion-ios-paper-outline tx-24"></i>
                    <span class="menu-item-label">Inventory</span>
                </div>
            </a>
        @endif

    </div>
    <br>
</div>
