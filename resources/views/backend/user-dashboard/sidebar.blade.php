<style>
    .c-dropdown-menu li{
        font-weight: 400!important;
        font-size: 20px!important;
    }
</style>
<div class="c-sidebar-menu collapse  text-center p-3" style="padding: 10px">
{{--    <div class="image">--}}
{{--        <img width="100" height="100" src="{{asset('uploads/propic/'.Auth::user()->image)}}" style="border-radius: 50%" alt="">--}}
{{--    </div>--}}
    <div class="name"><h1><strong>{{Auth::user()->name}}</strong></h1></div>
    <div class="badge badge-primary">{{Auth::user()->phone}} <br></div>
</div>
<ul class="c-sidebar-menu collapse" id="sidebar-menu-1">
    <li class="c-dropdown c-open">
        <a href="javascript:;" class="c-toggler"><strong>Menus</strong><span class="c-arrow"></span></a>
        <ul class="c-dropdown-menu">
            @if (Auth::User()->getRoleNames()[0] == 'Customer')
                <li class="{{Request::is('user/dashboard*') ? 'c-active' : ''}}">
                    <a href="{{route('user.dashboard')}}">My Dashbord</a>
                </li>
                <li class="{{Request::is('user/edit-profile*') ? 'c-active' : ''}}">
                    <a href="{{route('user.edit.profile')}}">View Profile</a>
                </li>
                <li class="{{Request::is('user/change-password*') ? 'c-active' : ''}}">
                    <a href="{{route('password.change')}}">Edit Password</a>
                </li>
                <li class="{{Request::is('user/product-history*') ? 'c-active' : ''}}">
                    <a href="{{route('product.history')}}">Order History</a>
                </li>

                <li class="">
                    <a href="#" class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out mr-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @elseif (Auth::User()->getRoleNames()[0] == 'Service Provider')
                <li class="{{Request::is('user/dashboard*') ? 'c-active' : ''}}">
                    <a href="{{route('user.dashboard')}}">My Dashbord</a>
                </li>
                <li class="{{Request::is('user/edit-profile*') ? 'c-active' : ''}}">
                    <a href="{{route('user.edit.profile')}}">View Profile</a>
                </li>
                <li class="{{Request::is('user/change-password*') ? 'c-active' : ''}}">
                    <a href="{{route('password.change')}}">Edit Password</a>
                </li>

                <li class="">
                    <a href="#" class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out mr-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endif
        </ul>
    </li>
</ul>
<!-- END: LAYOUT/SIDEBARS/SHOP-SIDEBAR-DASHBOARD -->
