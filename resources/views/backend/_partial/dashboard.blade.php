@include('backend._partial.header')
<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

@include('backend._partial.sidebar')


@yield('content')

@include('backend._partial.footer')

