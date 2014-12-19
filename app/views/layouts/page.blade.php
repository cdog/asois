@include('layouts.header')
<div class="container">
  @yield('tabs')
  @yield('content')
</div>{{-- .container --}}
@include('layouts.footer')
