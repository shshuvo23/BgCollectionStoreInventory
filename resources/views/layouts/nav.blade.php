<div class="br-header">
    <div class="br-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i
                    class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i
            class="icon ion-navicon-round"></i></a></div>
      </div>
    <div class="br-header-right">
        <nav class="nav">
            {{-- <div class="dropdown">
                <notification/>
            </div> --}}
            @if (auth()->user()->role_id == 2 or auth()->user()->role_id == 3 or auth()->user()->role_id == 6)
            <div class="dropdown">
                <a id="notificationButton" onclick="seenNotification()" href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown" >
                    <i class="icon ion-ios-bell-outline tx-24"></i>
                    @if (notificationSeenStatus())
                    <span class="square-8 bg-danger pos-absolute t-15 r-5 rounded-circle"></span>
                    @endif
                </a>
                 <div class="dropdown-menu dropdown-menu-header wd-300 pd-0-force " >
                    <div class="d-flex align-items-center justify-content-between pd-y-10 pd-x-20 bd-b bd-gray-200">
                        <label class="tx-12 tx-info tx-uppercase tx-semibold tx-spacing-2 mg-b-0">Notifications </label>
                        @if (unreadNotification())
                        <a href="" class="tx-11">Mark All as Read</a>
                        @endif
                    </div>
                    <div class="media-list" style="max-height:250px; overflow-y:auto">

                        @forelse (showNotification() as $notification)
                            @php
                                $notification_style = Crypt::encrypt($notification->style_id);
                                $notification_id = Crypt::encrypt($notification->id);
                                if ($notification->effected_accessories) {
                                    $message = $notification->effected_accessories.' '. $notification->message.' '.$notification->style_no;
                                }else{
                                    $message = $notification->message.' '.$notification->style_no;
                                }

                                $url = route('inventory.list', $notification_style).'?n_id='.$notification_id;
                            @endphp

                        <a href="{{ $url }}" class="media-list-link read">
                            <div class="media pd-x-20 pd-y-15 {{ $notification->status==0?'bg-grey':'bg-white' }}" >
                                <div class="media-body">
                                    <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">{{$message }}</strong></p>
                                    <span class="tx-12 text-right">{{ $notification->updated_at->diffForHumans() }}</span>

                                </div>
                            </div>
                        </a>
                        @empty
                            <div class="media pd-x-20 pd-y-15" >
                                <div class="media-body text-center">
                                    <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium text-danger ">No Notification</strong></p>

                                </div>
                            </div>
                        @endforelse
                        {{-- @if (allNotification())
                        <div class="pd-y-10 tx-center bd-t">
                            <a href="" class="tx-12"><i class="fa fa-angle-down mg-r-5"></i> Show All
                                Notifications</a>
                        </div>
                        @endif --}}
                    </div>
                </div>
            </div>
            @endif
            <div class="dropdown">
                <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
                    <span class="logged-name hidden-md-down">{{ auth()->user()->name }}</span>
                    <img src="{{ asset('assets/img/dummy-profile.jpeg') }}" class="wd-32 rounded-circle" alt="">
                    <span class="square-10 bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-200">
                    <ul class="list-unstyled user-profile-nav">
                        <li><a href="{{route('password.change')}}"><i class="icon ion-ios-gear"></i> Change Password</a></li>
                        <li>
                            <form id="logout_form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <a href="javascript:void(0)" onclick="document.getElementById('logout_form').submit();"><i
                                        class="icon ion-power"></i> Sign Out</a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
