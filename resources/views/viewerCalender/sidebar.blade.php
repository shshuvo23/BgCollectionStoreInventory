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

<a href="{{ route('order.management') }}" class="br-menu-link {{ isset($orderManagement) ? 'active' : '' }}">
    <div class="br-menu-item">
        <i class="menu-item-icon  icon ion-android-calendar tx-24"></i>
        <span class="menu-item-label">Export Calendar</span>
    </div>
</a>
