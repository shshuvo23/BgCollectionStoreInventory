<a href="{{ route('super_admin_dashboard') }}" class="br-menu-link {{ isset($dashboard) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="menu-item-icon icon ion-ios-person-outline tx-24"></i>
        <span class="menu-item-label">Dasboard</span>
    </div>
</a>

<a href="#" class="br-menu-link {{ isset($role_menu) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="menu-item-icon icon ion-ios-person-outline tx-24"></i>
        <span class="menu-item-label">Roles</span>
        <i class="menu-item-arrow fa fa-angle-down"></i>
    </div>
</a>
<ul class="br-menu-sub nav flex-column">
    <li class="nav-item"><a href="{{ route('role_list') }}" class="nav-link">Roles List</a></li>
    <li class="nav-item"><a href="{{ route('role_create') }}" class="nav-link">Add Role</a></li>
</ul>


<a href="#" class="br-menu-link {{ isset($users_menu) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="menu-item-icon icon ion-ios-person-outline tx-24"></i>
        <span class="menu-item-label">Users</span>
        <i class="menu-item-arrow fa fa-angle-down"></i>
    </div>
</a>
<ul class="br-menu-sub nav flex-column">
    <li class="nav-item"><a href="{{ route('users') }}" class="nav-link">Users List</a></li>
    <li class="nav-item"><a href="{{ route('create_user') }}" class="nav-link">Add User</a></li>
</ul>


<a href="{{ route('buyer.list') }}" class="br-menu-link {{ isset($buyer_list) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="fa fa-user"></i>
        <span class="menu-item-label">Buyer list</span>
    </div>
</a>
<a href="{{ route('order.list') }}" class="br-menu-link {{ isset($order_list) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="fa fa-user"></i>
        <span class="menu-item-label">Order list</span>
    </div>
</a>
<a href="{{ route('style.index') }}" class="br-menu-link {{ isset($style_page) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="fa fa-user"></i>
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
