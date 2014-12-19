@if (Session::has('alert_success'))
  <div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    {{ Session::get('alert_success') }}
  </div>{{-- .alert .alert-success .alert-dismissible --}}
@endif

@if (Session::has('alert_info'))
  <div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    {{ Session::get('alert_info') }}
  </div>{{-- .alert .alert-info .alert-dismissible --}}
@endif

@if (Session::has('alert_warning'))
  <div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    {{ Session::get('alert_warning') }}
  </div>{{-- .alert .alert-warning .alert-dismissible --}}
@endif

@if (Session::has('alert_danger'))
  <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    {{ Session::get('alert_danger') }}
  </div>{{-- .alert .alert-danger .alert-dismissible --}}
@endif
